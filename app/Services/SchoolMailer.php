<?php

namespace App\Services;

use App\Models\SportsSchool;
use Illuminate\Contracts\Mail\Mailer as MailerContract;
use Illuminate\Support\Facades\Mail;

/**
 * Provides per-school SMTP mailers.
 *
 * Usage:
 *   $mailer = SchoolMailer::forSchool($school);
 *   $mailer->to($email)->send(new MyMailable());
 *
 * The mailable should set ->from() using SchoolMailer::fromAddress($school).
 */
class SchoolMailer
{
    /**
     * Returns a mailer configured with the school's SMTP settings.
     * Falls back to the application default mailer when no config is stored.
     */
    public static function forSchool(SportsSchool $school): MailerContract
    {
        if (
            empty($school->mail_host) ||
            empty($school->mail_username) ||
            empty($school->mail_password)
        ) {
            return Mail::mailer(config('mail.default'));
        }

        return Mail::build([
            'transport'  => 'smtp',
            'host'       => $school->mail_host,
            'port'       => (int) ($school->mail_port ?? 587),
            'encryption' => $school->mail_encryption ?: 'tls',
            'username'   => $school->mail_username,
            'password'   => $school->mail_password,
            'timeout'    => 30,
        ]);
    }

    /**
     * Returns the [address, name] pair to use as the "From" for a school.
     * Falls back to the app-level mail.from config.
     */
    public static function fromAddress(SportsSchool $school): array
    {
        return [
            'address' => $school->mail_from_address
                ?: ($school->email ?? config('mail.from.address')),
            'name'    => $school->mail_from_name
                ?: ($school->name ?? config('mail.from.name')),
        ];
    }

    /**
     * Convenience: returns true when the school has a complete, usable SMTP config.
     */
    public static function isConfigured(SportsSchool $school): bool
    {
        return !empty($school->mail_host)
            && !empty($school->mail_username)
            && !empty($school->mail_password);
    }
}
