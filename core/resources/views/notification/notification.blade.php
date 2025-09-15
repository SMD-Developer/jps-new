@extends('app')

<style>
    .table-responsive {
        max-width: 100%;
        overflow-x: auto;
        white-space: nowrap;
    }

    table {
        width: 100%;
        table-layout: auto;
    }

    th,
    td {
        border: 1px solid #ddd;
        padding: 10px;
        text-align: left;
        white-space: normal;
        word-wrap: break-word;
        font-size: 13px;
    }

    th {
        background-color: #007bff;
        color: white;
        font-weight: 600;
        font-size: 14px;
    }

    .btn {
        padding: 7px 12px;
        border: none;
        cursor: pointer;
        font-weight: 600;
        border-radius: 5px;
        font-size: 13px;
    }

    .btn-mark-read {
        background-color: #28a745 !important;
        color: white !important;
    }

    .btn-mark-read:hover {
        background-color: #c82333 !important;
    }

    .btn-mark-all {
        background-color: #28a745 !important;
        color: white !important;
        padding: 8px 15px;
        margin-bottom: 10px;
        float: right;
        font-size: 14px;
    }

    .btn-mark-all:hover {
        background-color: #c82333 !important;
    }

    .header-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .unread {
        background-color: #f8f9fa;
        /* Light gray for unread notifications */
    }
</style>

<title>{{ $title }} | JPS</title>

@section('content')
    <div class="col-md-12 content-header">
        <h5><i class="fa fa-list-alt nav-icon"></i> {{ $title }}</h5>
    </div>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <!-- Notifications Table -->
                <div class="card">
                    <div class="card-body">
                        <div class="header-actions">
                            <!--<h6 style="margin: 0; font-size: 15px; font-weight: 600;">@lang('app.notifications')</h6>-->
                            <!--<button class="btn btn-mark-all" id="markAllAsRead">@lang('app.mark_all_as_read')</button>-->
                        </div>
                        <div class="table-responsive">
                            <table>
                                <thead>
                                    <tr>
                                        <th>@lang('app.bil')</th>
                                        <th>@lang('app.title')</th>
                                        <th>@lang('app.description')</th>
                                        <th>@lang('app.date')</th>
                                        <th>@lang('app.action')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (auth('admin')->check())
                                        @php
                                            $notifications = auth('admin')
                                                ->user()
                                                ->notifications()
                                                ->where('notifiable_type', 'App\Models\User')
                                                ->orderBy('created_at', 'desc')
                                                ->get();
                                        @endphp
                                        @forelse ($notifications as $index => $notification)
                                            <tr class="{{ $notification->read_at ? '' : 'unread' }}"
                                                data-id="{{ $notification->id }}">
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $notification->data['title'] ?? 'Notifikasi' }}</td>
                                                <td>
                                                    <a href="{{ route('application_list') }}?id={{ $notification->data['application_id'] ?? '' }}"
                                                        style="text-decoration: none; color: inherit;">
                                                        {{ $notification->data['message'] ?? 'No message' }}
                                                        @if (isset($notification->data['applicant']))
                                                            <br><small>{{ $notification->data['applicant'] }}</small>
                                                        @endif
                                                    </a>
                                                </td>
                                                <td>{{ $notification->created_at->format('d/m/Y h:i A') }}</td>
                                                <td>
                                                    @if (!$notification->read_at)
                                                        <button class="btn btn-mark-read btn-sm mark-as-read"
                                                            data-id="{{ $notification->id }}">
                                                            @lang('app.mark_as_read')
                                                        </button>
                                                    @else
                                                        <span style="color: gray;">@lang('app.read')</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center">@lang('app.no_notifications')</td>
                                            </tr>
                                        @endforelse
                                    @else
                                        <tr>
                                            <td colspan="5" class="text-center">Please log in to see notifications</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
         document.addEventListener('DOMContentLoaded', function() {
            updateNotificationCount();
            document.querySelectorAll('.mark-as-read').forEach(button => {
                button.addEventListener('click', function() {
                    const notificationId = this.getAttribute('data-id');
                    const currentRow = this.closest('tr'); 

                    fetch('/notifications/' + notificationId + '/mark-as-read', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector(
                                    'meta[name="csrf-token"]').getAttribute('content'),
                                'Content-Type': 'application/json',
                            },
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                if (currentRow) {
                                    currentRow.classList.remove('unread');
                                    const buttonInRow = currentRow.querySelector(
                                        '.mark-as-read');
                                    if (buttonInRow) {
                                        const span = document.createElement('span');
                                        span.style.color = 'gray';
                                        span.textContent = '{{ trans('app.read') }}';
                                        buttonInRow.parentNode.replaceChild(span, buttonInRow);
                                    }
                                }
                                updateNotificationCount();
                            }
                        })
                        .catch(error => console.error('Error:', error));
                });
            });

            document.getElementById('markAllAsRead').addEventListener('click', function(e) {
                e.preventDefault();
                fetch('/notifications/mark-all-as-read', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content'),
                            'Content-Type': 'application/json',
                        },
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            document.querySelectorAll('tr.unread').forEach(row => {
                                row.classList.remove('unread');
                                const button = row.querySelector('.mark-as-read');
                                if (button) {
                                    const span = document.createElement('span');
                                    span.style.color = 'gray';
                                    span.textContent = '{{ trans('app.read') }}';
                                    button.parentNode.replaceChild(span, button);
                                }
                            });

                            updateNotificationCount();
                            const navNotificationCount = document.querySelector('.notification-badge');
                            if (navNotificationCount) {
                                navNotificationCount.style.display = 'none';
                                navNotificationCount.textContent = '0';
                            }
                        }
                    })
                    .catch(error => console.error('Error:', error));
            });

            function updateNotificationCount() {
                const unreadCount = document.querySelectorAll('tr.unread').length;
                const notificationCountSpan = document.getElementById('notificationCount');
                if (notificationCountSpan) {
                    if (unreadCount > 0) {
                        notificationCountSpan.textContent = unreadCount;
                        notificationCountSpan.style.display = 'inline-block';
                    } else {
                        notificationCountSpan.style.display = 'none';
                    }
                }
                const navNotificationCount = document.querySelector('.notification-badge');
                if (navNotificationCount) {
                    if (unreadCount > 0) {
                        navNotificationCount.textContent = unreadCount;
                        navNotificationCount.style.display = 'inline-block';
                    } else {
                        navNotificationCount.style.display = 'none';
                    }
                }
            }
        });
    </script>
@endsection
