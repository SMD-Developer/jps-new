@extends('clientarea.app')
<meta name="csrf-token" content="{{ csrf_token() }}">
<style>
    /* Apply Poppins Font */
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap');

    body {
        font-family: 'Poppins', sans-serif;
        line-height: 1.5;
        margin: 20px;
        color: #333;
        font-weight: 400;
        font-size: 14px;
        /* Adjusted between 13px - 15px */
    }

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
        /* Slightly smaller for better readability */
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
        /* Align to right */
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
                        <!--<div class="header-actions">-->
                        <!--    <h6 style="margin: 0; font-size: 15px; font-weight: 600;">@lang('app.notifications')</h6>-->
                        <!--    <button class="btn btn-mark-all" id="markAllAsRead">@lang('app.mark_all_as_read')</button>-->
                        <!--</div>-->
                        <div class="table-responsive">
                            <table>
                                <thead>
                                    <tr>
                                        <th>@lang('app.bil')</th>
                                        <th>@lang('app.notificationss')</th>
                                        <th>@lang('app.description')</th>
                                        <th>@lang('app.date')</th>
                                        <th>@lang('app.action')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (auth('user')->check())
                                        @php
                                            $notifications = auth('user')
                                                ->user()
                                                ->notifications()
                                                ->orderBy('created_at', 'desc')
                                                ->get();
                                        @endphp
                                        @forelse ($notifications as $index => $notification)
                                            <tr class="{{ $notification->read_at ? '' : 'unread' }}"
                                                data-id="{{ $notification->id }}">
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $notification->data['title'] ?? 'Notification' }}</td>
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
            // Mark individual notification as read
            document.querySelectorAll('.mark-as-read').forEach(button => {
                button.addEventListener('click', function() {
                    const notificationId = this.getAttribute('data-id');

                    fetch('/user-notifications/' + notificationId + '/mark-as-read', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector(
                                    'meta[name="csrf-token"]').getAttribute('content'),
                                'Content-Type': 'application/json',
                            },
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.json();
                        })
                        .then(data => {
                            if (data.success) {
                                const row = this.closest('tr');
                                row.classList.remove('unread');

                                const span = document.createElement('span');
                                span.style.color = 'gray';
                                span.textContent = '{{ trans('app.read') }}';
                                this.parentNode.replaceChild(span, this);
                            } else {
                                console.error('Failed to mark as read:', data.message);
                            }
                        })
                        .catch(error => console.error('Error marking notification as read:',
                        error));
                });
            });

            // Mark all notifications as read
            document.getElementById('markAllAsRead').addEventListener('click', function(e) {
                e.preventDefault();

                fetch('{{ route('user.notifications.mark_all_as_read') }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content'),
                            'Content-Type': 'application/json',
                        },
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
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
                        } else {
                            console.error('Failed to mark all as read:', data.message);
                        }
                    })
                    .catch(error => console.error('Error marking all notifications as read:', error));
            });
        });
    </script>
@endsection
