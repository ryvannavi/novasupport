<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Faq;

class FaqSeeder extends Seeder {
    public function run(): void {
        $faqs = [
            // Getting Started
            ['category'=>'getting-started','order'=>1,'question'=>'How do I create an account?','answer'=>'Visit our registration page and enter your name, email, and password. Once registered, you will be automatically redirected to your dashboard. No email verification is required to get started.'],
            ['category'=>'getting-started','order'=>2,'question'=>'How do I submit my first support ticket?','answer'=>'After logging in, click the "Submit Request" button in the top navigation. Fill in the title and describe your issue in detail. Our AI will generate an instant response, and our support team will follow up shortly.'],
            ['category'=>'getting-started','order'=>3,'question'=>'What happens after I submit a ticket?','answer'=>'Our AI system immediately analyzes your request and generates a suggested response. An admin reviews and approves the response before it reaches you. You will receive a notification once a reply is ready.'],
            ['category'=>'getting-started','order'=>4,'question'=>'Can I track the status of my ticket?','answer'=>'Yes! Go to "My Requests" in the navigation to see all your tickets and their current status: Open, In Progress, or Resolved. You can click any ticket to view the full conversation thread.'],

            // Authentication
            ['category'=>'authentication','order'=>1,'question'=>'How do I reset my password?','answer'=>'Click "Forgot Password" on the login page and enter your registered email. You will receive a password reset link within a few minutes. The link expires after 60 minutes for security reasons.'],
            ['category'=>'authentication','order'=>2,'question'=>'Why can\'t I log in to my account?','answer'=>'Make sure you are using the correct email and password. If you have forgotten your password, use the "Forgot Password" option. If the issue persists, submit a support ticket and our team will assist you.'],
            ['category'=>'authentication','order'=>3,'question'=>'How are admin accounts created?','answer'=>'Admin accounts are automatically assigned when the registered email contains "adm". This is a built-in role detection system. Regular emails create standard customer accounts.'],

            // Billing
            ['category'=>'billing','order'=>1,'question'=>'Is NovaSupport free to use?','answer'=>'NovaSupport offers a free tier for basic support ticket management. Premium plans include advanced AI features, priority support, and detailed analytics. Contact our team for enterprise pricing.'],
            ['category'=>'billing','order'=>2,'question'=>'What payment methods are accepted?','answer'=>'We accept all major credit cards (Visa, Mastercard, American Express), PayPal, and bank transfers for enterprise accounts. All payments are processed securely through our payment gateway.'],
            ['category'=>'billing','order'=>3,'question'=>'Can I cancel my subscription anytime?','answer'=>'Yes, you can cancel your subscription at any time from your account settings. Your access will continue until the end of the current billing period. No cancellation fees apply.'],

            // Advanced Settings
            ['category'=>'advanced-settings','order'=>1,'question'=>'Can I customize my notification preferences?','answer'=>'Yes, you can manage notification settings from your profile page. Choose to receive notifications for new replies, status changes, or all activity on your tickets.'],
            ['category'=>'advanced-settings','order'=>2,'question'=>'How do I update my profile information?','answer'=>'Click on your name in the top navigation and select "Profile". You can update your name, email, and password from this page. Changes are saved immediately.'],
            ['category'=>'advanced-settings','order'=>3,'question'=>'Is there an API available for integration?','answer'=>'Yes, NovaSupport provides a RESTful API for enterprise integrations. API documentation is available for authenticated admin users. Contact our team for API key access.'],

            // Technical Issues
            ['category'=>'technical-issues','order'=>1,'question'=>'The page is not loading correctly. What should I do?','answer'=>'First, try clearing your browser cache and cookies. If the issue persists, try a different browser or disable browser extensions. Check our status page for any ongoing incidents.'],
            ['category'=>'technical-issues','order'=>2,'question'=>'I am not receiving email notifications. Why?','answer'=>'Check your spam or junk folder first. Make sure your email address is correct in your profile. Add our email domain to your safe senders list. If the issue continues, submit a support ticket.'],
            ['category'=>'technical-issues','order'=>3,'question'=>'The AI response seems incorrect. What should I do?','answer'=>'AI responses are reviewed and approved by our admin team before being sent to you. If you feel a response does not address your issue, simply reply to your ticket with more details and our team will provide a manual response.'],
            ['category'=>'technical-issues','order'=>4,'question'=>'Why is my ticket status not updating?','answer'=>'Ticket status is updated manually by our support team as they work through your issue. You will receive a notification each time your ticket status changes. Refresh the page if you are not seeing recent updates.'],

            // Analytics
            ['category'=>'analytics','order'=>1,'question'=>'What does the Analytics Dashboard show?','answer'=>'The Analytics Dashboard (available to admins) shows total tickets, open/in-progress/resolved counts, average response time, AI approval rates, customer satisfaction scores, and ticket volume over the last 30 days.'],
            ['category'=>'analytics','order'=>2,'question'=>'How is the AI Approval Rate calculated?','answer'=>'The AI Approval Rate is the percentage of AI-generated responses that admins approved and sent to customers, versus those that were rejected. A high approval rate indicates the AI is performing well.'],
            ['category'=>'analytics','order'=>3,'question'=>'What is the Customer Satisfaction score?','answer'=>'After a ticket is resolved, customers can rate their experience from 1 to 5 stars with an optional comment. The average of all ratings is displayed as the Customer Satisfaction score in the analytics dashboard.'],
        ];

        foreach ($faqs as $faq) {
            Faq::create($faq);
        }
    }
}