<?php

namespace Tests\Unit;

use App\Mail\MailDemandeAbsence;
use App\Models\Absence;
use App\Models\Motif;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class MailDemandeAbsenceTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_it_builds_the_mail_with_correct_data()
    {
        $absence = Absence::factory()->create();
        $user = User::factory()->create();
        $motif = Motif::factory()->create();

        $mail = new MailDemandeAbsence($absence, $user, $motif);

        $this->assertEquals(__('Absence request'), $mail->envelope()->subject);

        $this->assertEquals('mail.demande_absence', $mail->content()->view);
    }

    /** @test */
    public function test_it_sends_the_mail()
    {
        Mail::fake();

        $absence = Absence::factory()->create();
        $user = User::factory()->create();
        $motif = Motif::factory()->create();

        Mail::to($user->email)->send(new MailDemandeAbsence($absence, $user, $motif));

        Mail::assertSent(MailDemandeAbsence::class, function ($mail) use ($absence, $user, $motif) {
            return $mail->absence->is($absence) &&
                   $mail->user->is($user) &&
                   $mail->motif->is($motif) &&
                   $mail->hasTo($user->email);
        });
    }

    /** @test */
    public function test_it_has_no_attachments()
    {
        $absence = Absence::factory()->create();
        $user = User::factory()->create();
        $motif = Motif::factory()->create();

        $mail = new MailDemandeAbsence($absence, $user, $motif);

        $this->assertEmpty($mail->attachments());
    }
}
