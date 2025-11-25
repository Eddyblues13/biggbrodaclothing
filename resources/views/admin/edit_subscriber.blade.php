@include('admin.header')

<div class="main-panel">
    <div class="content bg-light">
        <div class="page-inner">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="title1 text-dark">Edit Subscriber</h1>
                    <p class="text-muted">Update subscriber information</p>
                </div>
                <div>
                    <a href="{{ route('admin.subscribers.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Subscribers
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
                            <h4 class="card-title">Subscriber Information</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.subscribers.update', $subscriber->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="first_name">First Name</label>
                                            <input type="text" class="form-control" id="first_name" name="first_name" 
                                                   value="{{ old('first_name', $subscriber->first_name) }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="last_name">Last Name</label>
                                            <input type="text" class="form-control" id="last_name" name="last_name" 
                                                   value="{{ old('last_name', $subscriber->last_name) }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="email">Email Address *</label>
                                    <input type="email" class="form-control" id="email" name="email" 
                                           value="{{ old('email', $subscriber->email) }}" required>
                                </div>

                                <div class="form-group">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active" 
                                               {{ old('is_active', $subscriber->is_active) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_active">
                                            Active Subscriber
                                        </label>
                                        <small class="form-text text-muted">
                                            Inactive subscribers will not receive newsletter emails.
                                        </small>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save"></i> Update Subscriber
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
                            <h4 class="card-title">Subscriber Details</h4>
                        </div>
                        <div class="card-body">
                            <div class="text-center mb-4">
                                <div class="bg-primary text-white rounded-circle mx-auto mb-3" 
                                     style="width: 60px; height: 60px; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-envelope fa-2x"></i>
                                </div>
                                <h5>{{ $subscriber->email }}</h5>
                                <p class="text-muted">
                                    @if($subscriber->first_name || $subscriber->last_name)
                                        {{ $subscriber->first_name }} {{ $subscriber->last_name }}
                                    @else
                                        Name not provided
                                    @endif
                                </p>
                            </div>

                            <div class="stats-card mb-3">
                                <h4 class="{{ $subscriber->is_active ? 'text-success' : 'text-secondary' }}">
                                    {{ $subscriber->is_active ? 'Active' : 'Inactive' }}
                                </h4>
                                <p class="mb-0">Status</p>
                            </div>

                            <div class="stats-card">
                                <h4 class="text-info">{{ $subscriber->created_at->diffForHumans() }}</h4>
                                <p class="mb-0">Subscribed</p>
                            </div>
                        </div>
                    </div>

                    <div class="card mt-4">
                        <div class="card-header">
                            <h4 class="card-title">Quick Actions</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.subscribers.toggle-status', $subscriber->id) }}" method="POST" class="mb-2">
                                @csrf
                                <button type="submit" class="btn btn-{{ $subscriber->is_active ? 'warning' : 'success' }} btn-block">
                                    <i class="fas fa-{{ $subscriber->is_active ? 'pause' : 'play' }}"></i> 
                                    {{ $subscriber->is_active ? 'Deactivate' : 'Activate' }}
                                </button>
                            </form>

                            <form action="{{ route('admin.subscribers.destroy', $subscriber->id) }}" method="POST" 
                                  onsubmit="return confirm('Are you sure you want to delete this subscriber?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-block">
                                    <i class="fas fa-trash"></i> Delete Subscriber
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