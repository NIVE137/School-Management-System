<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\LeaveRequest;

class LeaveRequestNotification extends Mailable
{
    use Queueable, SerializesModels;

    public LeaveRequest $leaveRequest;

    /**
     * Create a new message instance.
     */
    public function __construct(LeaveRequest $leaveRequest)
    {
        $this->leaveRequest = $leaveRequest;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Leave Application: ' . $this->leaveRequest->applicant_name . ' (' . $this->leaveRequest->leave_type . ')',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            htmlString: '
            <div style="font-family: Arial, sans-serif; background-color: #f4f6f9; padding: 24px; color: #333;">
                <div style="max-width: 600px; margin: 0 auto; background: #ffffff; border-radius: 10px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.08);">
                    <div style="background: linear-gradient(135deg, #696cff, #03c3ec); padding: 20px 24px; color: #ffffff;">
                        <h3 style="margin: 0; font-size: 20px; font-weight: 700;">School Management System</h3>
                        <p style="margin: 4px 0 0 0; font-size: 14px; opacity: 0.9;">New Leave Request Notification</p>
                    </div>
                    <div style="padding: 24px;">
                        <p style="font-size: 15px; margin-top: 0;">Hello Administrator,</p>
                        <p style="font-size: 14px; color: #555;">A new leave request has been submitted and requires your review:</p>

                        <table style="width: 100%; border-collapse: collapse; margin: 18px 0; font-size: 14px;">
                            <tr style="border-bottom: 1px solid #eee;">
                                <td style="padding: 10px 0; font-weight: 600; color: #666; width: 140px;">Applicant:</td>
                                <td style="padding: 10px 0; color: #111; font-weight: 700;">' . htmlspecialchars($this->leaveRequest->applicant_name) . ' (' . ucfirst($this->leaveRequest->applicant_type) . ')</td>
                            </tr>
                            <tr style="border-bottom: 1px solid #eee;">
                                <td style="padding: 10px 0; font-weight: 600; color: #666;">Leave Type:</td>
                                <td style="padding: 10px 0; color: #111;">' . htmlspecialchars($this->leaveRequest->leave_type) . '</td>
                            </tr>
                            <tr style="border-bottom: 1px solid #eee;">
                                <td style="padding: 10px 0; font-weight: 600; color: #666;">Start Date:</td>
                                <td style="padding: 10px 0; color: #111;">' . htmlspecialchars($this->leaveRequest->start_date) . '</td>
                            </tr>
                            <tr style="border-bottom: 1px solid #eee;">
                                <td style="padding: 10px 0; font-weight: 600; color: #666;">End Date:</td>
                                <td style="padding: 10px 0; color: #111;">' . htmlspecialchars($this->leaveRequest->end_date) . '</td>
                            </tr>
                            <tr style="border-bottom: 1px solid #eee;">
                                <td style="padding: 10px 0; font-weight: 600; color: #666;">Reason:</td>
                                <td style="padding: 10px 0; color: #111;">' . htmlspecialchars($this->leaveRequest->reason) . '</td>
                            </tr>
                        </table>

                        <p style="font-size: 14px; color: #555;">Please log in to your admin panel to approve or reject this request.</p>

                        <div style="margin-top: 24px; text-align: center;">
                            <a href="' . route('leaverequests') . '" style="background: #696cff; color: #ffffff; text-decoration: none; padding: 12px 26px; border-radius: 6px; font-weight: 600; display: inline-block; font-size: 14px;">View Leave Requests</a>
                        </div>
                    </div>
                    <div style="background-color: #f8f9fa; padding: 14px 24px; text-align: center; font-size: 12px; color: #888; border-top: 1px solid #eee;">
                        This is an automated notification from School Management System.
                    </div>
                </div>
            </div>'
        );
    }
}
