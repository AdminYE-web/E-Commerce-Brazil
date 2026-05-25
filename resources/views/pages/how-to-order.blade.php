@extends('layouts.app')

@section('title', 'how to order')

@section('css')
    <style>
        /* คลุมหน้าเว็บทั้งหมด */
        .order-page-container {
            background-color: #fcfdfe;
            /* ปรับพื้นหลังให้อ่อนลงตามภาพ */
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333333;
            padding-bottom: 5rem;
        }

        /* ส่วนหัวแบนเนอร์สีน้ำเงินเข้ม */
        .order-header {
            background-color: #0d3c7c;
            color: #ffffff;
            text-align: center;
            padding: 5rem 1rem;
            position: relative;
        }

        .header-title {
            font-size: 2.8rem;
            font-weight: 800;
            margin: 0 0 0.5rem 0;
            letter-spacing: 0.02em;
        }

        .header-subtitle {
            font-size: 1rem;
            color: #dae7f6;
            margin: 0;
            font-weight: 400;
        }

        /* กล่องจัดการระยะหน้าเว็บบรรจุเนื้อหา */
        .order-content-wrap {
            max-width: 940px;
            margin: 0 auto;
            padding: 0 1.5rem;
        }

        /* โครงสร้างแต่ละ Step ใหญ่ */
        .step-block {
            margin-top: 1.5rem;
            margin-bottom: 1rem;
        }

        /* แถบหัวข้อ Step (ดีไซน์โค้งมน และไล่เฉดสีกว้างโปร่งตามภาพจริง) */
        .step-header {
            background: linear-gradient(to right, #cef0ff 0%, #eef9ff 40%, #ffffff 100%);
            padding: 0.6rem 1.25rem;
            display: flex;
            align-items: center;
            border-radius: 16px;
            /* โค้งมนแบบอิสระรอบด้าน */
            margin-bottom: 1.8rem;
            padding: 20px 34px;
            /* เว้นระยะห่างก่อนถึงกล่องข้อความด้านล่าง */
        }

        .step-icon-box {
            background-color: #ffffff;
            padding: 0.6rem;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 8px rgba(11, 60, 123, 0.08);
            border: 1px solid #eef4f8;
        }

        .step-icon-box img {
            width: 28px;
            height: 28px;
            object-fit: contain;
        }

        .step-title {
            font-size: 1.35rem;
            font-weight: 700;
            color: #000000;
            margin: 0;
            padding-left: 1rem;
        }

        /* กล่องเนื้อหาหลัก (ตัดขอบมนเท่ากันหมดรอบตัว แยกอิสระจากหัวข้อ) */
        .step-body-card {
            background-color: #ffffff;
            border: 1px solid #e3e8ec;
            border-radius: 12px;
            /* โค้งมนทุกมุมเท่ากัน */
            padding: 2.2rem 2.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
        }

        /* ส่วนเนื้อหาภายใน Step 1 */
        .step-body-card p {
            font-size: 0.95rem;
            color: #444444;
            margin: 0 0 0.6rem 0;
            line-height: 1.6;
        }

        .body-highlight {
            font-weight: 600;
            color: #222222 !important;
            margin-bottom: 0.8rem !important;
        }

        .step-link {
            color: #3b82f6;
            text-decoration: underline;
            font-size: 0.95rem;
            display: inline-block;
            margin-top: 0.2rem;
        }

        .step-link:hover {
            color: #1d4ed8;
        }

        /* การจัดแบ่ง Section ย่อยภายในกล่อง Step 2 (ใช้เส้นแบ่งบางๆ) */
        .list-section .sub-step {
            padding-top: 1.8rem;
            padding-bottom: 1.8rem;
            border-bottom: 1px solid #edf2f6;
        }

        .list-section .sub-step:first-child {
            padding-top: 0;
        }

        .list-section .sub-step:last-child {
            padding-bottom: 0;
            border-bottom: none;
        }

        .list-section h3 {
            font-size: 1rem;
            font-weight: 700;
            color: #000000;
            margin: 0 0 0.6rem 0;
        }

        /* ปรับแต่งรายการ Bullet Points */
        .list-section ul {
            margin: 0;
            padding-left: 1.2rem;
            color: #444444;
        }

        .list-section li {
            margin-bottom: 0.3rem;
            font-size: 0.95rem;
            line-height: 1.5;
            list-style-type: disc;
        }

        .list-section li::marker {
            color: #333333;
            font-size: 0.85rem;
        }

        /* รายละเอียดปลีกย่อยเพิ่มเติม */
        .price-notice {
            color: #444444;
            margin-top: 0.5rem !important;
        }

        .nested-parts {
            padding-top: 0.2rem;
        }

        .nested-parts p {
            margin-bottom: 1rem;
        }

        .nested-parts ul {
            margin-top: 0.4rem;
            margin-bottom: 0.6rem;
        }

        .italic-text {
            font-size: 0.9rem;
            color: #555555;
            display: inline-block;
            margin-top: 0.2rem;
        }

        .muted-text {
            font-size: 0.88rem;
            color: #88929a;
            margin: 0;
        }

        /* Responsive สำหรับมือถือ */
        @media (max-width: 768px) {
            .header-title {
                font-size: 2.2rem;
            }

            .step-body-card {
                padding: 1.5rem;
            }

            .step-header {
                padding: 0.5rem 1rem;
            }

            .step-title {
                font-size: 1.15rem;
            }
        }
    </style>
@endsection

@section('content')
    <div class="order-page-container">

        <div class="order-header">
            <h1 class="header-title">How to order</h1>
            <p class="header-subtitle">Start your custom order in just a few easy steps.</p>
        </div>

        <div class="order-content-wrap">

            <div class="step-block">
                <div class="step-header">

                    <img src="{{ asset('assets/images/icon/fluent-mdl2_product-variant.png') }}" alt="Product Variant">

                    <h2 class="step-title">Step 1 : Choose Your Product</h2>
                </div>

                <div class="step-body-card">
                    <p class="body-highlight">Choose Your Product</p>
                    <p>Our website offers a wide variety of employee lanyards and customizable components.</p>
                    <p>We provide 22 standard lanyard colors, optional special custom colors, and over 10 types of ID
                        holders—some free when ordered with lanyards.</p>
                    <a href="#" class="step-link">Click here to start your order.</a>
                </div>
            </div>

            <div class="step-block">
                <div class="step-header">

                    <img src="{{ asset('assets/images/icon/fluent_box-edit-20-regular.png') }}" alt="Start Your Order">

                    <h2 class="step-title">Step 2 : Start Your Order</h2>
                </div>

                <div class="step-body-card list-section">

                    <div class="sub-step">
                        <h3>Step 1: Select Your Lanyard Type</h3>
                        <p>Choose from four lanyard styles:</p>
                        <ul>
                            <li>Premium</li>
                            <li>Polyester</li>
                            <li>Nylon</li>
                            <li>Sublimation</li>
                        </ul>
                    </div>

                    <div class="sub-step">
                        <h3>Step 2: Select Your Lanyard Color</h3>
                        <ul>
                            <li>Up to 5 standard colors</li>
                            <li>Additional standard colors: $8 per color / per order</li>
                            <li>Up to 3 special colors</li>
                            <li>Special colors: $40 per color / per order</li>
                        </ul>
                    </div>

                    <div class="sub-step">
                        <h3>Step 3: Choose Your Print Color</h3>
                        <p>If no color is selected, white will be used by default.</p>
                        <p class="price-notice">Print color fee: $25 per color / per order</p>
                    </div>

                    <div class="sub-step">
                        <h3>Step 4: Choose Your Parts & Options</h3>
                        <div class="nested-parts">
                            <p><strong>4.1 Attachments</strong><br>Choose from 8 clip options, including badge reels. (Some
                                attachments are free; others have additional fees.)</p>
                            <p><strong>4.2 Add-On Components</strong><br>Optional accessories can be added for an extra
                                cost.</p>
                            <p><strong>4.3 Sample Production</strong><br>Physical samples can be produced based on standard
                                production time.</p>
                            <p><strong>4.4 Urgent Production Service</strong></p>
                            <ul>
                                <li>+20% rush fee (min. $55 per order)</li>
                                <li>Max 500 pcs</li>
                                <li>Available for Polyester, Nylon, and Sublimation lanyards</li>
                            </ul>
                            <span class="italic-text">Same quality — delivered faster.</span>
                        </div>
                    </div>

                    <div class="sub-step">
                        <h3>Step 5: Select Your ID Holder</h3>
                        <p>Choose from multiple ID holders — free or paid options.</p>
                    </div>

                    <div class="sub-step">
                        <h3>Step 6: Enter Your Order Quantity</h3>
                        <p>Minimum: 20 pcs</p>
                        <p>Maximum: 50,000 pcs</p>
                        <p class="muted-text">Minimum quantity may vary based on previous selections.</p>
                    </div>

                </div>
            </div>
            <div class="step-block">
                <div class="step-header">

                    <img src="{{ asset('assets/images/icon/solar_document-add-outline.png') }}" alt="Product Variant">

                    <h2 class="step-title">Step 3 : Enter Your Order Details</h2>
                </div>

                <div class="step-body-card">
                    <p>On the next page, fill in your contact information to confirm your order.
                        <br>Your information will be kept strictly confidential and used only for communication regarding
                        your order.
                        <br>Upload your lanyard design file under Design File, or download our design template to simplify
                        the process.
                    </p>
                </div>
            </div>
            <div class="step-block">
                <div class="step-header">

                    <img src="{{ asset('assets/images/icon/fluent_box-checkmark-16-regular.png') }}" alt="Product Variant">

                    <h2 class="step-title">Step 4 : Review & Confirm</h2>
                </div>

                <div class="step-body-card">
                    <p>After reviewing your details, click Send to finalize your order.
                        <br>You will receive a confirmation email from xxxxx@xxxxxx.com
                        <br>Your quotation is valid for 7 days for payment.
                        <br>Once payment is completed—or if you have further questions—please contact us at:
                        <br>Email: xxxxx@xxxxxx.com
                        <br>Tel: -
                    </p>
                </div>
            </div>

        </div>
    </div>
@endsection
