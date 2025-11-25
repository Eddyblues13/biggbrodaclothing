@include('admin.header')

<div class="main-panel">
    <div class="content bg-light">
        <div class="page-inner">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="title1 text-dark">Edit User</h1>
                    <p class="text-muted">Update user information</p>
                </div>
                <div>
                    <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to User
                    </a>
                </div>
            </div>

            @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif

            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">User Information</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="first_name">First Name *</label>
                                            <input type="text" class="form-control" id="first_name" name="first_name" 
                                                   value="{{ old('first_name', $user->first_name) }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="last_name">Last Name *</label>
                                            <input type="text" class="form-control" id="last_name" name="last_name" 
                                                   value="{{ old('last_name', $user->last_name) }}" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email">Email Address *</label>
                                            <input type="email" class="form-control" id="email" name="email" 
                                                   value="{{ old('email', $user->email) }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="phone">Phone Number *</label>
                                            <input type="text" class="form-control" id="phone" name="phone" 
                                                   value="{{ old('phone', $user->phone) }}" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="password">New Password</label>
                                            <input type="password" class="form-control" id="password" name="password">
                                            <small class="form-text text-muted">Leave blank to keep current password</small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="password_confirmation">Confirm New Password</label>
                                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="email_verified" 
                                               {{ $user->email_verified_at ? 'checked' : '' }} disabled>
                                        <label class="form-check-label" for="email_verified">
                                            Email Verified
                                        </label>
                                        <small class="form-text text-muted">
                                            To change verification status, use the verify/unverify button on the user details page.
                                        </small>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save"></i> Update User
                                    </button>
                                    <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-secondary">Cancel</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">User Statistics</h4>
                        </div>
                        <div class="card-body">
                            <div class="text-center mb-4">
                                <div class="user-avatar-large mx-auto mb-3" style="width: 60px; height: 60px; font-size: 1.2rem;">
                                    {{ strtoupper(substr($user->first_name, 0, 1)) }}{{ strtoupper(substr($user->last_name, 0, 1)) }}
                                </div>
                                <h5>{{ $user->first_name }} {{ $user->last_name }}</h5>
                                <p class="text-muted">{{ $user->email }}</p>
                            </div>

                            <div class="stats-card mb-3">
                                <h4 class="text-primary">{{ $user->orders_count }}</h4>
                                <p class="mb-0">Total Orders</p>
                            </div>

                            <div class="stats-card mb-3">
                                <h4 class="text-success">{{ $user->addresses->count() }}</h4>
                                <p class="mb-0">Saved Addresses</p>
                            </div>

                            <div class="stats-card">
                                <h4 class="text-info">{{ $user->created_at->diffForHumans() }}</h4>
                                <p class="mb-0">Member Since</p>
                            </div>
                        </div>
                    </div>

                    <div class="card mt-4">
                        <div class="card-header">
                            <h4 class="card-title">Danger Zone</h4>
                        </div>
                        <div class="card-body">
                            <p class="text-muted">Once you delete a user, there is no going back. Please be certain.</p>
                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" 
                                  onsubmit="return confirm('Are you sure you want to delete this user? This action cannot be undone.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-block">
                                    <i class="fas fa-trash"></i> Delete User
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('admin.footer')