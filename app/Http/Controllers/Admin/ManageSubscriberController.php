<?php

namespace App\Http\Controllers\Admin;

use App\Models\Subscriber;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ManageSubscriberController extends Controller
{
    public function index(Request $request)
    {
        $query = Subscriber::latest();

        // Apply filters
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('email', 'like', "%{$search}%")
                  ->orWhere('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%");
            });
        }

        if ($request->has('status') && $request->status != '') {
            $query->where('is_active', $request->status === 'active');
        }

        $subscribers = $query->paginate(15);

        return view('admin.manage_subscribers', compact('subscribers'));
    }

    public function create()
    {
        return view('admin.create_subscriber');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|unique:subscribers,email',
            'first_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ]);

        try {
            Subscriber::create([
                'email' => $validated['email'],
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'is_active' => $request->has('is_active'),
            ]);

            return redirect()->route('admin.subscribers.index')->with('success', 'Subscriber added successfully!');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error adding subscriber: ' . $e->getMessage());
        }
    }

    public function edit(Subscriber $subscriber)
    {
        return view('admin.edit_subscriber', compact('subscriber'));
    }

    public function update(Request $request, Subscriber $subscriber)
    {
        $validated = $request->validate([
            'email' => 'required|email|unique:subscribers,email,' . $subscriber->id,
            'first_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ]);

        try {
            $subscriber->update([
                'email' => $validated['email'],
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'is_active' => $request->has('is_active'),
            ]);

            return redirect()->route('admin.subscribers.index')->with('success', 'Subscriber updated successfully!');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error updating subscriber: ' . $e->getMessage());
        }
    }

    public function destroy(Subscriber $subscriber)
    {
        try {
            $subscriber->delete();

            return redirect()->route('admin.subscribers.index')->with('success', 'Subscriber deleted successfully.');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error deleting subscriber: ' . $e->getMessage());
        }
    }

    public function toggleStatus(Subscriber $subscriber)
    {
        try {
            $subscriber->update([
                'is_active' => !$subscriber->is_active
            ]);

            $status = $subscriber->is_active ? 'activated' : 'deactivated';
            return redirect()->back()->with('success', "Subscriber {$status} successfully.");

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error updating subscriber status: ' . $e->getMessage());
        }
    }

    public function bulkAction(Request $request)
    {
        $request->validate([
            'subscriber_ids' => 'required|array',
            'subscriber_ids.*' => 'exists:subscribers,id',
            'action' => 'required|in:activate,deactivate,delete'
        ]);

        $subscriberIds = $request->subscriber_ids;
        $action = $request->action;

        try {
            foreach ($subscriberIds as $subscriberId) {
                $subscriber = Subscriber::find($subscriberId);

                switch ($action) {
                    case 'activate':
                        $subscriber->update(['is_active' => true]);
                        break;

                    case 'deactivate':
                        $subscriber->update(['is_active' => false]);
                        break;

                    case 'delete':
                        $subscriber->delete();
                        break;
                }
            }

            $message = match($action) {
                'activate' => 'Selected subscribers activated successfully.',
                'deactivate' => 'Selected subscribers deactivated successfully.',
                'delete' => 'Selected subscribers deleted successfully.',
            };

            return redirect()->back()->with('success', $message);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error performing bulk action: ' . $e->getMessage());
        }
    }

    public function export(Request $request)
    {
        $subscribers = Subscriber::where('is_active', true)->get();

        $filename = "subscribers-" . date('Y-m-d') . ".csv";
        $handle = fopen('php://output', 'w');
        fputcsv($handle, ['Email', 'First Name', 'Last Name', 'Subscription Date']);

        foreach ($subscribers as $subscriber) {
            fputcsv($handle, [
                $subscriber->email,
                $subscriber->first_name,
                $subscriber->last_name,
                $subscriber->created_at->format('Y-m-d')
            ]);
        }

        fclose($handle);

        return response()->streamDownload(function() use ($handle) {
            //
        }, $filename, [
            'Content-Type' => 'text/csv',
        ]);
    }


     public function showEmailForm()
    {
        $activeSubscribersCount = Subscriber::where('is_active', true)->count();
        return view('admin.email_subscribers', compact('activeSubscribersCount'));
    }

    public function sendBulkEmail(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'subscriber_type' => 'required|in:all,active,inactive'
        ]);

        try {
            $query = Subscriber::query();
            
            if ($request->subscriber_type === 'active') {
                $query->where('is_active', true);
            } elseif ($request->subscriber_type === 'inactive') {
                $query->where('is_active', false);
            }

            $subscribers = $query->get();
            $sentCount = 0;

            foreach ($subscribers as $subscriber) {
                try {
                    Mail::to($subscriber->email)->send(new NewsletterMail(
                        $request->subject,
                        $request->message,
                        $subscriber
                    ));
                    $sentCount++;
                } catch (\Exception $e) {
                    // Log failed email but continue with others
                    \Log::error("Failed to send email to {$subscriber->email}: " . $e->getMessage());
                }
            }

            return redirect()->route('admin.subscribers.index')
                ->with('success', "Newsletter sent successfully to {$sentCount} subscribers.");

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error sending newsletter: ' . $e->getMessage());
        }
    }

    public function sendIndividualEmail(Request $request, Subscriber $subscriber)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        try {
            Mail::to($subscriber->email)->send(new CustomSubscriberMail(
                $request->subject,
                $request->message
            ));

            return redirect()->route('admin.subscribers.index')
                ->with('success', "Email sent successfully to {$subscriber->email}.");

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error sending email: ' . $e->getMessage());
        }
    }

    public function showIndividualEmailForm(Subscriber $subscriber)
    {
        return view('admin.email_individual_subscriber', compact('subscriber'));
    }
}