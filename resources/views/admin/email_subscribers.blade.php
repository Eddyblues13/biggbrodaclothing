@include('admin.header')

<div class="main-panel">
    <div class="content bg-light">
        <div class="page-inner">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="title1 text-dark">Send Newsletter</h1>
                    <p class="text-muted">Send email to all subscribers</p>
                </div>
                <div>
                    <a href="{{ route('admin.subscribers.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Subscribers
                    </a>
                </div>
            </div>

            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif

            @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif

            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Compose Newsletter</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.subscribers.send-bulk-email') }}" method="POST" id="newsletterForm">
                                @csrf
                                
                                <div class="form-group">
                                    <label for="subscriber_type">Send To *</label>
                                    <select class="form-control" id="subscriber_type" name="subscriber_type" required>
                                        <option value="all">All Subscribers</option>
                                        <option value="active">Active Subscribers Only</option>
                                        <option value="inactive">Inactive Subscribers Only</option>
                                    </select>
                                    <small class="form-text text-muted">
                                        <span id="subscriberCount">Active subscribers: {{ $activeSubscribersCount }}</span>
                                    </small>
                                </div>

                                <div class="form-group">
                                    <label for="subject">Subject *</label>
                                    <input type="text" class="form-control" id="subject" name="subject" 
                                           placeholder="Enter email subject" required>
                                </div>

                                <div class="form-group">
                                    <label for="message">Message *</label>
                                    <textarea class="form-control" id="message" name="message" rows="12" 
                                              placeholder="Enter your newsletter content..." required></textarea>
                                    <small class="form-text text-muted">
                                        You can use HTML tags for formatting.
                                    </small>
                                </div>

                                <div class="form-group">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="preview" name="preview">
                                        <label class="form-check-label" for="preview">
                                            Send test email to myself first
                                        </label>
                                    </div>
                                </div>

                                <div class="alert alert-warning">
                                    <i class="fas fa-exclamation-triangle"></i>
                                    <strong>Warning:</strong> This will send an email to all selected subscribers. This action cannot be undone.
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary" id="sendButton">
                                        <i class="fas fa-paper-plane"></i> Send Newsletter
                                    </button>
                                    <button type="button" class="btn btn-info" id="previewButton">
                                        <i class="fas fa-eye"></i> Preview
                                    </button>
                                    <a href="{{ route('admin.subscribers.index') }}" class="btn btn-secondary">Cancel</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Quick Stats</h4>
                        </div>
                        <div class="card-body">
                            <div class="stats-card mb-3 bg-primary text-white">
                                <h4>{{ $activeSubscribersCount }}</h4>
                                <p class="mb-0">Active Subscribers</p>
                            </div>

                            <div class="stats-card mb-3 bg-info text-white">
                                <h4>{{ \App\Models\Subscriber::where('is_active', false)->count() }}</h4>
                                <p class="mb-0">Inactive Subscribers</p>
                            </div>

                            <div class="stats-card bg-success text-white">
                                <h4>{{ \App\Models\Subscriber::count() }}</h4>
                                <p class="mb-0">Total Subscribers</p>
                            </div>
                        </div>
                    </div>

                    <div class="card mt-4">
                        <div class="card-header">
                            <h4 class="card-title">Tips</h4>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled">
                                <li class="mb-2">
                                    <i class="fas fa-lightbulb text-warning"></i>
                                    Keep subject lines short and engaging
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-lightbulb text-warning"></i>
                                    Personalize with subscriber names when possible
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-lightbulb text-warning"></i>
                                    Test with a small group first
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-lightbulb text-warning"></i>
                                    Include clear call-to-actions
                                </li>
                                <li>
                                    <i class="fas fa-lightbulb text-warning"></i>
                                    Check spam score before sending
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const subscriberType = document.getElementById('subscriber_type');
    const subscriberCount = document.getElementById('subscriberCount');
    const sendButton = document.getElementById('sendButton');
    const form = document.getElementById('newsletterForm');

    subscriberType.addEventListener('change', function() {
        const type = this.value;
        let count = 0;
        
        switch(type) {
            case 'all':
                count = {{ \App\Models\Subscriber::count() }};
                break;
            case 'active':
                count = {{ $activeSubscribersCount }};
                break;
            case 'inactive':
                count = {{ \App\Models\Subscriber::where('is_active', false)->count() }};
                break;
        }
        
        subscriberCount.textContent = `Recipients: ${count} subscribers`;
    });

    sendButton.addEventListener('click', function(e) {
        const subject = document.getElementById('subject').value;
        const message = document.getElementById('message').value;
        
        if (!subject || !message) {
            return;
        }

        const recipientCount = {
            'all': {{ \App\Models\Subscriber::count() }},
            'active': {{ $activeSubscribersCount }},
            'inactive': {{ \App\Models\Subscriber::where('is_active', false)->count() }}
        }[subscriberType.value];

        if (!confirm(`Are you sure you want to send this newsletter to ${recipientCount} subscribers?`)) {
            e.preventDefault();
        }
    });
});
</script>

@include('admin.footer')