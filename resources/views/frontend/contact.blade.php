Set-Content -Path "resources/views/frontend/contact.blade.php" -Encoding UTF8 -Value @'
@extends('frontend.layouts.app')

@section('title', 'Contact Pharma Company | PharmaCare')
@section('meta_description', 'Contact PharmaCare for product enquiry, business enquiry, distribution support and pharmaceutical information.')

@section('content')

<section class="page-hero">
    <div class="container">
        <h1>Contact Us</h1>
        <p>
            Send your business or product enquiry. Our team will contact you shortly.
        </p>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="contact-grid">
            <div class="contact-info">
                <h2>Get In Touch</h2>
                <p>
                    For product details, business enquiry, distribution or company information,
                    please fill the enquiry form.
                </p>

                <div class="info-box">
                    <strong>Phone</strong>
                    <span>+91-0000000000</span>
                </div>

                <div class="info-box">
                    <strong>Email</strong>
                    <span>info@example.com</span>
                </div>

                <div class="info-box">
                    <strong>Address</strong>
                    <span>Your Company Address, City, State, India</span>
                </div>
            </div>

            <form class="contact-form" action="#" method="POST">
                @csrf

                <div class="form-row">
                    <div>
                        <label>Your Name</label>
                        <input type="text" name="name" placeholder="Enter your name">
                    </div>

                    <div>
                        <label>Phone Number</label>
                        <input type="text" name="phone" placeholder="Enter phone number">
                    </div>
                </div>

                <div class="form-row">
                    <div>
                        <label>Email Address</label>
                        <input type="email" name="email" placeholder="Enter email address">
                    </div>

                    <div>
                        <label>Company Name</label>
                        <input type="text" name="company_name" placeholder="Enter company name">
                    </div>
                </div>

                <div>
                    <label>Subject</label>
                    <input type="text" name="subject" placeholder="Product / Business enquiry">
                </div>

                <div>
                    <label>Message</label>
                    <textarea name="message" rows="5" placeholder="Write your message"></textarea>
                </div>

                <button type="submit">Submit Enquiry</button>
            </form>
        </div>
    </div>
</section>

<style>
    .contact-grid {
        display: grid;
        grid-template-columns: .85fr 1.15fr;
        gap: 35px;
        align-items: start;
    }

    .contact-info,
    .contact-form {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 26px;
        padding: 34px;
        box-shadow: 0 18px 45px rgba(15, 23, 42, 0.08);
    }

    .contact-info h2 {
        margin: 0 0 14px;
        color: #062f4f;
        font-size: 34px;
    }

    .contact-info p {
        color: #475569;
        line-height: 1.8;
        margin-bottom: 28px;
    }

    .info-box {
        padding: 18px;
        border-radius: 18px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        margin-bottom: 14px;
        display: grid;
        gap: 6px;
    }

    .info-box strong {
        color: #047857;
    }

    .info-box span {
        color: #475569;
    }

    .contact-form {
        display: grid;
        gap: 18px;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 18px;
    }

    label {
        display: block;
        margin-bottom: 8px;
        font-weight: 800;
        color: #0f172a;
    }

    input,
    textarea {
        width: 100%;
        border: 1px solid #cbd5e1;
        border-radius: 14px;
        padding: 14px 16px;
        font-size: 15px;
        outline: none;
        background: #fff;
    }

    input:focus,
    textarea:focus {
        border-color: #047857;
        box-shadow: 0 0 0 4px rgba(4, 120, 87, .10);
    }

    button {
        border: 0;
        background: #047857;
        color: #fff;
        padding: 15px 24px;
        border-radius: 999px;
        font-weight: 900;
        cursor: pointer;
        box-shadow: 0 15px 30px rgba(4, 120, 87, .22);
    }

    @media(max-width: 900px) {
        .contact-grid,
        .form-row {
            grid-template-columns: 1fr;
        }
    }
</style>

@endsection
'@