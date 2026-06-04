@include('admin.layouts.header')
@include('admin.layouts.menu')

<style>
    .activity-log-table td,
    .activity-log-table th {
        vertical-align: top;
    }

    .activity-log-values {
        max-width: 360px;
        white-space: normal;
        word-break: break-word;
        font-size: 0.86rem;
    }

    .activity-log-values code {
        color: #1b4332;
        background: #eef7f0;
        padding: 2px 5px;
        border-radius: 4px;
    }

    .activity-log-meta {
        color: #6c757d;
        font-size: 0.86rem;
    }
</style>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Log Aktivitas Admin</h1>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <form method="GET" action="{{ route('activity-logs.index') }}">
                        <div class="row">
                            <div class="col-md-3 mb-2">
                                <input type="text" name="search" class="form-control"
                                    placeholder="Cari admin / aksi / objek..." value="{{ request('search') }}">
                            </div>
                            <div class="col-md-2 mb-2">
                                <select name="user_id" class="form-control">
                                    <option value="">Semua Admin</option>
                                    @foreach($admins as $admin)
                                        <option value="{{ $admin->id }}" {{ (string) request('user_id') === (string) $admin->id ? 'selected' : '' }}>
                                            {{ $admin->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2 mb-2">
                                <select name="action" class="form-control">
                                    <option value="">Semua Aksi</option>
                                    @foreach($actions as $action)
                                        <option value="{{ $action }}" {{ request('action') === $action ? 'selected' : '' }}>
                                            {{ ucwords(str_replace('_', ' ', $action)) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2 mb-2">
                                <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
                            </div>
                            <div class="col-md-2 mb-2">
                                <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
                            </div>
                            <div class="col-md-1 mb-2 d-flex">
                                <button type="submit" class="btn btn-success mr-1" title="Filter">
                                    <i class="fas fa-search"></i>
                                </button>
                                <a href="{{ route('activity-logs.index') }}" class="btn btn-secondary" title="Reset">
                                    <i class="fas fa-sync-alt"></i>
                                </a>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="card-body table-responsive">
                    <table class="table table-bordered table-hover activity-log-table">
                        <thead>
                            <tr>
                                <th width="150">Waktu</th>
                                <th width="190">Admin</th>
                                <th width="130">Aksi</th>
                                <th width="170">Objek</th>
                                <th>Perubahan</th>
                                <th width="130">IP</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($logs as $log)
                                <tr>
                                    <td>
                                        {{ $log->created_at->format('d/m/Y H:i:s') }}
                                    </td>
                                    <td>
                                        <strong>{{ $log->user_name ?? $log->user->name ?? 'Admin tidak ditemukan' }}</strong>
                                        <div class="activity-log-meta">{{ $log->user_email ?? $log->user->email ?? '-' }}</div>
                                    </td>
                                    <td>
                                        <span class="badge badge-info">
                                            {{ ucwords(str_replace('_', ' ', $log->action)) }}
                                        </span>
                                    </td>
                                    <td>
                                        <strong>{{ $log->subject_label ?? '-' }}</strong>
                                        <div class="activity-log-meta">
                                            {{ $log->subject_type ?? '-' }} #{{ $log->subject_id ?? '-' }}
                                        </div>
                                    </td>
                                    <td class="activity-log-values">
                                        @if($log->description)
                                            <div class="mb-2">{{ $log->description }}</div>
                                        @endif

                                        @php
                                            $oldValues = $log->old_values ?? [];
                                            $newValues = $log->new_values ?? [];
                                            $keys = collect(array_keys($oldValues))
                                                ->merge(array_keys($newValues))
                                                ->unique();
                                        @endphp

                                        @forelse($keys as $key)
                                            <div>
                                                <code>{{ $key }}</code>:
                                                <span class="text-danger">{{ data_get($oldValues, $key, '-') }}</span>
                                                <i class="fas fa-arrow-right mx-1 text-muted"></i>
                                                <span class="text-success">{{ data_get($newValues, $key, '-') }}</span>
                                            </div>
                                        @empty
                                            <span class="text-muted">Tidak ada detail field.</span>
                                        @endforelse
                                    </td>
                                    <td>
                                        {{ $log->ip_address ?? '-' }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">
                                        Belum ada log aktivitas.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($logs->hasPages())
                    <div class="card-footer">
                        {{ $logs->links() }}
                    </div>
                @endif
            </div>
        </div>
    </section>
</div>
