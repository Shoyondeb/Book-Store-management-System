<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class TestEmail extends Command
{
    protected $signature = 'email:test';
    protected $description = 'Test email configuration';

    public function handle()
    {
        try {
            Mail::raw('Test email from BookStore', function ($message) {
                $message->to('shoyondeb18246@gmail.com')
                    ->subject('BookStore Email Test');
            });

            $this->info('✅ Email sent successfully!');
        } catch (\Exception $e) {
            $this->error('❌ Email failed: ' . $e->getMessage());
        }
    }
}
