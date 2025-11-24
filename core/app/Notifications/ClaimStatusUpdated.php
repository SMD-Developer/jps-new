<?php

namespace App\Notifications;
use App\Models\ClaimContribution;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ClaimStatusUpdated extends Notification 
{
    use Queueable;

    protected $claim;
    protected $oldStatus;

    public function __construct(ClaimContribution $claim, $oldStatus = null)
    {
        $this->claim = $claim;
        $this->oldStatus = $oldStatus;
    }

    public function via($notifiable)
    {
        return ['database', 'mail'];
    }


    public function toMail($notifiable)
    {
        $statusLabel = $this->getStatusLabel($this->claim->status);
        $statusColor = $this->getStatusColor($this->claim->status);

        return (new MailMessage)
            ->subject('Status Pemulangan Balik Caruman Parit')
            ->markdown('emails.claim-status-updated', [
                'notifiable' => $notifiable,
                'claim' => $this->claim,
                'statusLabel' => $statusLabel,
                'statusColor' => $statusColor,
                'oldStatus' => $this->oldStatus,
            ]);
    }


    public function toDatabase($notifiable)
    {
        return [
            'claim_id' => $this->claim->id ?? null,
            'applicant' => $this->claim->applicant ?? 'N/A',
            'district' => $this->claim->district ?? 'N/A',
            'message' => 'Status tuntutan anda telah dikemas kini',
            'type' => 'claim_status_update'
        ];
    }


    
    public function toArray($notifiable)
    {
        return [
            'message' => 'Status tuntutan anda telah dikemaskini ke: ' . $this->getStatusLabel($this->claim->status),
            'claim_id' => $this->claim->id,
            'old_status' => $this->oldStatus ?? 'N/A',
            'new_status' => $this->claim->status,
            'created_at' => now()->toDateTimeString(),
        ];
    }

    protected function getStatusLabel($status)
    {
        $labels = [
            'pending' => 'Menunggu Ulasan',
            'approve_payment_in_process' => 'Pembayaran Dalam Proses',
            'rejected' => 'Ditolak',
            'approve_paid' => 'Diluluskan & Dibayar',
        ];

        return $labels[$status] ?? ucfirst(str_replace('_', ' ', $status));
    }

    protected function getStatusColor($status)
    {
        $colors = [
            'pending' => '#FFA500',                      // Orange
            'approve_payment_in_process' => '#4169E1',   // Royal Blue
            'rejected' => '#DC143C',                     // Crimson Red
            'approve_paid' => '#28A745',                 // Green (changed from #FFA500)
        ];

        return $colors[$status] ?? '#808080';
    }
}