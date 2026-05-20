@extends('layouts.app')

@section('title', 'Customize ' . $product->product_name)

@section('css')
    <style>
        .customize-page {
            background: #f5f6f8;
            padding: 40px 20px;
        }

        .customize-container {
            max-width: 1180px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1fr 1.1fr;
            gap: 40px;
        }

        .customize-left,
        .customize-right {
            background: #fff;
            padding: 24px;
            border-radius: 8px;
        }

        .option-group {
            margin-bottom: 28px;
        }

        .option-group h3 {
            font-size: 18px;
            margin-bottom: 14px;
        }

        .option-list {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
        }

        .option-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 12px;
            cursor: pointer;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .option-card:has(input:checked) {
            border-color: #3166f6;
            box-shadow: 0 0 0 2px rgba(49, 102, 246, 0.15);
        }

        .option-card input {
            margin-bottom: 4px;
        }

        .customize-page {
            background: #f5f6f8;
            padding: 28px 20px 60px;
        }

        .customize-container {
            max-width: 1180px;
            margin: 0 auto;
        }

        .customize-breadcrumb {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 13px;
            color: #111;
            margin-bottom: 18px;
        }

        .customize-breadcrumb img {
            width: 14px;
            height: 14px;
            object-fit: contain;
        }

        .customize-breadcrumb a {
            color: #555;
            text-decoration: none;
        }

        .customize-hero-section {
            margin-bottom: 36px;
        }

        .customize-hero-banner {
            position: relative;
            width: 100%;
            border-radius: 14px;
            overflow: hidden;
            background: #0f3f86;
        }

        .customize-hero-banner img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        /* overlay เผื่อให้อ่านตัวหนังสือชัด */
        .customize-hero-banner::after {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(90deg,
                    rgba(0, 35, 90, 0.75) 0%,
                    rgba(0, 35, 90, 0.35) 42%,
                    rgba(0, 35, 90, 0.05) 100%);
        }

        .customize-hero-content {
            position: absolute;
            inset: 0;
            z-index: 2;
            display: flex;
            align-items: center;
            padding: 50px 80px;
        }

        .customize-hero-content h1 {
            max-width: 430px;
            margin: 0;
            color: #fff;
            font-size: 38px;
            line-height: 1.25;
            font-weight: 800;
        }

        .customize-page {
            background: #f5f6f8;
            padding: 28px 20px 70px;
        }

        .customize-container {
            max-width: 1180px;
            margin: 0 auto;
        }

        .customize-breadcrumb {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 13px;
            color: #111;
            margin-bottom: 18px;
        }

        .customize-breadcrumb img {
            width: 14px;
            height: 14px;
            object-fit: contain;
        }

        .customize-hero-section {
            margin-bottom: 34px;
        }

        .customize-hero-banner {
            position: relative;
            width: 100%;
            height: 320px;
            border-radius: 14px;
            overflow: hidden;
            background: #0f3f86;
        }

        .customize-hero-banner img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .customize-hero-banner::after {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(90deg,
                    rgba(0, 35, 90, 0.75) 0%,
                    rgba(0, 35, 90, 0.28) 44%,
                    rgba(0, 35, 90, 0.05) 100%);
        }

        .customize-hero-content {
            position: absolute;
            inset: 0;
            z-index: 2;
            display: flex;
            align-items: center;
            padding: 50px 80px;
        }

        .customize-hero-content h1 {
            max-width: 440px;
            color: #fff;
            font-size: 38px;
            line-height: 1.25;
            font-weight: 800;
            margin: 0;
        }

        .customize-layout {
            display: grid;
            grid-template-columns: 1fr 340px;
            gap: 36px;
            align-items: start;
            margin-top: 30px;
        }

        .customize-option-group {
            margin-bottom: 34px;
        }

        .customize-option-group h2 {
            font-size: 28px;
            font-weight: 600;
            margin: 0 0 16px;
        }

        .customize-option-group .required {
            color: #ff0000;
        }

        .info-icon {
            font-size: 14px;
            font-weight: 400;
            margin-left: 4px;
        }

        .option-image-grid {
            display: grid;
            grid-template-columns: repeat(2, 204px);
            gap: 12px;
        }

        .option-image-card {
            background: #fff;
            border: 1px solid #d9dde7;
            border-radius: 6px;
            min-height: 140px;
            padding: 10px 12px;
            cursor: pointer;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .option-image-card input,
        .option-button-item input,
        .option-color-item input {
            display: none;
        }

        .option-image-card:has(input:checked),
        .option-button-item:has(input:checked) {
            border-color: #3166f6;
            box-shadow: 0 0 0 1px #3166f6;
        }

        .option-image-box {
            height: 95px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .option-image-box img {
            max-width: 100%;
            max-height: 90px;
            object-fit: contain;
        }

        .option-image-card span {
            font-size: 16px;
            color: #111;
        }

        .option-button-list {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
        }

        .option-button-item {
            min-width: 84px;
            height: 42px;
            border: 1px solid #d9dde7;
            border-radius: 6px;
            background: #fff;
            padding: 0 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }

        .option-button-item span {
            font-size: 16px;
        }

        .option-color-list {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            max-width: 430px;
        }

        .option-color-item {
            cursor: pointer;
            display: inline-flex;
        }

        .color-circle {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            border: 2px solid transparent;
            display: inline-block;
        }

        .option-color-item input:checked+.color-circle {
            outline: 3px solid #3166f6;
            outline-offset: 3px;
        }

        .add-color-btn {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            border: 1px solid #d9dde7;
            background: #fff;
            font-size: 24px;
            line-height: 1;
            cursor: pointer;
        }

        .product-summary-box {
            background: #fff;
            border: 1px solid #d9dde7;
            border-radius: 6px;
            padding: 20px 18px;
            position: sticky;
            top: 111px;
        }

        .product-summary-box h3 {
            font-size: 25px;
            font-weight: 800;
            margin: 0 0 16px;
        }

        .summary-item {
            margin-bottom: 12px;
        }

        .summary-item span {
            display: block;
            font-size: 16px;
            color: #616161;
            margin-bottom: 4px;
        }

        .summary-item strong {
            display: block;
            font-size: 16px;
            color: #616161;
        }

        .summary-divider {
            height: 1px;
            background: #e5e7eb;
            margin: 16px 0;
        }

        .summary-total span {
            display: block;
            color: #1d3970;
            font-weight: 800;
            margin-bottom: 4px;
        }

        .summary-total strong {
            color: #1d3970;
            font-size: 22px;
        }

        .no-options {
            background: #fff;
            padding: 20px;
            border-radius: 6px;
        }

        @media (max-width: 900px) {
            .customize-layout {
                grid-template-columns: 1fr;
            }

            .product-summary-box {
                position: static;
            }

            .customize-hero-banner {
                height: 240px;
            }

            .customize-hero-content {
                padding: 30px;
            }

            .customize-hero-content h1 {
                font-size: 28px;
            }
        }

        @media (max-width: 520px) {
            .option-image-grid {
                grid-template-columns: 1fr;
            }

            .customize-page {
                padding: 22px 14px 50px;
            }
        }

        @media (max-width: 768px) {
            .customize-hero-banner {
                height: 230px;
                border-radius: 10px;
            }

            .customize-hero-content {
                padding: 30px;
            }

            .customize-hero-content h1 {
                font-size: 28px;
            }
        }

        @media (max-width: 480px) {
            .customize-hero-banner {
                height: 200px;
            }

            .customize-hero-content h1 {
                font-size: 24px;
            }
        }

        @media (max-width: 900px) {
            .customize-container {
                grid-template-columns: 1fr;
            }

            .option-list {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        .option-select-detail-box {
            max-width: 760px;
        }

        .option-select-detail {
            width: 100%;
            max-width: 620px;
            height: 42px;
            border: 1px solid #d9dde7;
            border-radius: 6px;
            padding: 0 14px;
            background: #fff;
            font-size: 14px;
            margin-bottom: 12px;
        }

        .select-detail-preview {
            display: grid;
            grid-template-columns: 170px 1fr;
            gap: 20px;
            align-items: start;
        }

        .select-detail-image {
            background: #fff;
            border: 1px solid #d9dde7;
            border-radius: 6px;
            width: 170px;
            height: 170px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .select-detail-image img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }

        .select-detail-text {
            font-size: 13px;
            line-height: 1.7;
            color: #111827;
            white-space: normal;
        }

        @media (max-width: 600px) {
            .select-detail-preview {
                grid-template-columns: 1fr;
            }

            .select-detail-image {
                width: 100%;
            }
        }

        .option-variant-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 18px;
        }

        .option-variant-card {
            width: 124px;
            min-height: 158px;
            background: #fff;
            border: 1px solid #d9dde7;
            border-radius: 10px;
            padding: 10px;
            cursor: pointer;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .option-variant-card input[type="radio"] {
            display: none;
        }

        .option-variant-card:has(input[type="radio"]:checked) {
            border-color: #3166f6;
            box-shadow: 0 0 0 1px #3166f6;
        }

        .variant-title {
            font-size: 16px;
            font-weight: 600;
            line-height: 1.2;
            text-align: center;
            min-height: 32px;
            margin-bottom: 6px;
        }

        .variant-image-box {
            height: 82px;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .variant-image-box img {
            max-height: 78px;
            max-width: 100%;
            object-fit: contain;
        }

        .variant-select {
            width: 100%;
            height: 28px;
            border: 1px solid #d9dde7;
            border-radius: 14px;
            padding: 0 8px;
            font-size: 12px;
            margin-top: 6px;
            background: #fff;
        }

        .variant-dropdown {
            width: 100%;
            margin-top: 8px;
        }

        .variant-dropdown-btn {
            width: 100%;
            height: 32px;
            border: 1px solid #d9dde7;
            border-radius: 16px;
            background: #fff;
            font-size: 12px;
            padding: 4px 10px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .variant-dropdown-btn::after {
            margin-left: auto;
        }

        .variant-dropdown-label {
            margin-left: 6px;
            margin-right: auto;
        }

        .variant-dropdown-menu {
            width: 100%;
            min-width: 100%;
            padding: 4px;
        }

        .variant-dropdown-item {
            font-size: 12px;
            display: flex;
            align-items: center;
            gap: 7px;
            border-radius: 6px;
        }

        .variant-color-dot {
            width: 14px;
            height: 14px;
            border-radius: 50%;
            display: inline-block;
            border: 1px solid #cbd5e1;
            flex-shrink: 0;
        }

        .custom-color-box {
            margin-top: 18px;
            max-width: 520px;
        }

        .custom-color-label {
            display: block;
            font-size: 15px;
            margin-bottom: 10px;
            color: #111827;
        }

        .custom-color-input-row {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .custom-color-input {
            width: 100%;
            height: 38px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            padding: 0 14px;
            font-size: 14px;
            background: #fff;
        }

        .custom-color-input::placeholder {
            color: #9ca3af;
        }

        .custom-color-add-btn {
            border: 0;
            background: transparent;
            font-size: 14px;
            color: #111;
            cursor: pointer;
            padding: 0 4px;
        }

        .add-color-btn.is-active {
            outline: 3px solid #3166f6;
            outline-offset: 3px;
        }

        .option-compact-grid {
            display: grid;
            grid-template-columns: repeat(4, 126px);
            gap: 18px;
        }

        .option-compact-card {
            background: #fff;
            border: 1px solid #d9dde7;
            border-radius: 10px;
            min-height: 160px;
            padding: 10px 8px 12px;
            cursor: pointer;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .option-compact-card input {
            display: none;
        }

        .option-compact-card:has(input:checked) {
            border-color: #3166f6;
            box-shadow: 0 0 0 1px #3166f6;
        }

        .option-compact-image {
            height: 88px;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .option-compact-image img {
            max-width: 100%;
            max-height: 86px;
            object-fit: contain;
        }

        .option-compact-name {
            font-size: 14px;
            line-height: 1.35;
            color: #111;
            margin-top: 8px;
            min-height: 38px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .option-compact-price {
            font-size: 13px;
            margin-top: 4px;
            color: #111;
        }

        .option-compact-price.free {
            color: #ff0000;
        }

        .option-view-more-wrap {
            width: calc((126px * 4) + (18px * 3));
            text-align: center;
            margin-top: 16px;
        }

        .option-view-more-btn {
            background: #3166f6;
            color: #fff;
            border: 0;
            border-radius: 6px;
            padding: 8px 28px;
            font-size: 14px;
            cursor: pointer;
        }

        @media (max-width: 768px) {
            .option-compact-grid {
                grid-template-columns: repeat(2, 126px);
            }

            .option-view-more-wrap {
                width: 100%;
                text-align: left;
            }
        }

        @media (max-width: 420px) {
            .option-compact-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        .info-popover-btn {
            border: 0;
            background: transparent;
            padding: 0;
            margin-left: 4px;
            font-size: 15px;
            line-height: 1;
            cursor: pointer;
            color: #111;
        }

        .popover {
            max-width: 420px;
            border-radius: 8px;
            border: 1px solid #d1d5db;
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.08);
        }

        .popover-body {
            font-size: 14px;
            line-height: 1.7;
            color: #111;
            padding: 12px 16px;
        }

        .grouped-buttons-wrapper {
            margin-top: 10px;
        }

        .grouped-button-set {
            margin-bottom: 28px;
        }

        .grouped-button-title {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 17px;
            font-weight: 500;
            color: #111;
            margin-bottom: 12px;
        }

        .grouped-option-button {
            min-width: 144px;
            height: 50px;
            font-size: 18px;
            border-radius: 8px;
        }

        .grouped-option-button span {
            font-size: 18px;
            font-weight: 500;
        }

        .info-popover-btn {
            border: 0;
            background: transparent;
            padding: 0;
            margin-left: 4px;
            font-size: 15px;
            line-height: 1;
            cursor: pointer;
            color: #111;
        }

        .popover {
            max-width: 420px;
            border-radius: 8px;
            border: 1px solid #d1d5db;
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.08);
        }

        .popover-body {
            font-size: 14px;
            line-height: 1.7;
            color: #111;
            padding: 12px 16px;
        }

        .quantity-add-cart-section {
            margin-top: 46px;
            max-width: 780px;
        }

        .quantity-label-row {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 10px;
            font-size: 16px;
        }

        .quantity-label-row label {
            color: #111;
            font-weight: 400;
        }

        .minimum-note {
            color: #ff1f2d;
            font-size: 16px;
        }

        .quantity-input-row {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .quantity-input-row input {
            width: 110px;
            height: 39px;
            border: 1px solid #cfd4dc;
            border-radius: 10px;
            background: #fff;
            font-size: 16px;
            font-weight: 600;
            text-align: center;
        }

        .quantity-input-row span {
            font-size: 18px;
            color: #111;
        }

        .add-to-cart-btn {
            width: 100%;
            height: 66px;
            margin-top: 74px;
            border: 0;
            border-radius: 10px;
            background: #2f6fc2;
            color: #fff;
            font-size: 20px;
            font-weight: 600;
            letter-spacing: 0.5px;
            cursor: pointer;
        }

        .add-to-cart-btn:hover {
            background: #255fac;
        }

        @media (max-width: 768px) {
            .customize-option-group h2 {
    font-size: 14px;
   
}
.option-button-item span {
    font-size: 13px;
}
            .quantity-label-row {
                flex-direction: column;
                align-items: flex-start;
                gap: 4px;
            }

            .add-to-cart-btn {
                margin-top: 40px;
                height: 56px;
                font-size: 16px;
            }
        }

        .option-required-error {
            margin-top: 10px;
            color: #dc2626;
            font-size: 14px;
            font-weight: 500;
        }

        /* .customize-option-group.has-error h2 {
                            color: #dc2626;
                        } */

        /* .customize-option-group.has-error .option-button-item,
                        .customize-option-group.has-error .option-image-card,
                        .customize-option-group.has-error .option-variant-card,
                        .customize-option-group.has-error .option-compact-card,
                        .customize-option-group.has-error .option-select-detail {
                            border-color: #dc2626;
                        } */
        .previous-order-box {
            max-width: 620px;
        }

        .previous-order-choice-list {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }

        .previous-order-choice {
            min-width: 110px;
            height: 44px;
            border: 1px solid #d9dde7;
            border-radius: 8px;
            background: #fff;
            padding: 0 22px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }

        .previous-order-choice input {
            display: none;
        }

        .previous-order-choice:has(input:checked) {
            border-color: #3166f6;
            box-shadow: 0 0 0 1px #3166f6;
        }

        .previous-order-input-box {
            margin-top: 14px;
            display: none;
        }

        .previous-order-input-box.is-open {
            display: block;
        }

        .previous-order-input-box label {
            display: block;
            font-size: 14px;
            margin-bottom: 8px;
            color: #111;
        }

        .previous-order-input-box input {
            width: 100%;
            height: 42px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            padding: 0 14px;
            font-size: 14px;
        }
        /* =========================
   STEP FOCUS / OVERLAY MODE
========================= */

.customize-option-group {
    position: relative;
    transition: all 0.25s ease;
}

.step-focus-overlay {
    position: fixed;
    inset: 0;
    background: rgba(17, 24, 39, 0.42);
    opacity: 0;
    visibility: hidden;
    transition: all 0.25s ease;
    z-index: 1000;
}

body.step-focus-open .step-focus-overlay {
    opacity: 1;
    visibility: visible;
}

.customize-option-group.is-step-active {
    background: #fff;
    border-radius: 16px;
    padding: 26px 26px 30px;
    box-shadow: 0 18px 48px rgba(15, 23, 42, 0.18);
    z-index: 1002;
}

.customize-option-group.is-step-active h2 {
    margin-top: 0;
}

.step-bottom-bar {
    position: fixed;
    left: 0;
    right: 0;
    bottom: 0;
    background: #ffffff;
    border-top: 1px solid #e5e7eb;
    box-shadow: 0 -8px 24px rgba(0, 0, 0, 0.08);
    padding: 14px 24px;
    z-index: 1004;

    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 18px;

    opacity: 0;
    visibility: hidden;
    transform: translateY(100%);
    transition: all 0.25s ease;
}

.step-bottom-bar.is-open {
    opacity: 1;
    visibility: visible;
    transform: translateY(0);
}

.step-bottom-bar-left,
.step-bottom-bar-right {
    display: flex;
    align-items: center;
    gap: 14px;
}

.step-bottom-bar-center {
    text-align: end;
    flex: 1;
    padding-right: 24px;
}

.step-total-main {
    font-size: 24px;
    font-weight: 800;
    color: #1d3970;
    line-height: 1.1;
}

.step-total-sub {
    font-size: 14px;
    color: #374151;
    margin-top: 2px;
}

.step-bar-btn {
    height: 41px;
    width: 244px;
    border-radius: 12px;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
    padding: 0 22px;
}

.step-bar-btn-prev {
    background: #fff;
    border: 1px solid #cfd4dc;
    color: #6b7280;
}

.step-bar-btn-prev:hover {
    border-color: #9ca3af;
    color: #111827;
}

.step-bar-btn-next {
    background: #082369;
    border: 1px solid #1d4ed8;
    color: #fff;
}

.step-bar-btn-next:hover {
    background: #1e40af;
    border-color: #1e40af;
}

.step-bar-btn:disabled {
    opacity: 0.45;
    cursor: not-allowed;
}

.step-focus-close {
    position: absolute;
    right: 16px;
    top: 16px;
    width: 34px;
    height: 34px;
    border-radius: 50%;
    border: 0;
    background: #fff;
    box-shadow: 0 4px 14px rgba(15, 23, 42, 0.14);
    font-size: 22px;
    line-height: 1;
    color: #9ca3af;
    z-index: 2;
    display: none;
    align-items: center;
    justify-content: center;
    cursor: pointer;
}

.customize-option-group.is-step-active .step-focus-close {
    display: inline-flex;
}

@media (max-width: 768px) {
    .customize-option-group.is-step-active {
        padding: 18px;
        border-radius: 12px;
    }

    .step-bottom-bar {
        padding: 12px 14px;
        flex-wrap: wrap;
        gap: 12px;
    }

    .step-bottom-bar-left,
    .step-bottom-bar-right {
        width: 100%;
    }

    .step-bottom-bar-left,
    .step-bottom-bar-right,
    .step-bottom-bar-center {
        justify-content: center;
        text-align: center;
    }

    .step-bar-btn {
        min-width: 140px;
        height: 48px;
        font-size: 14px;
    }

    .step-total-main {
        font-size: 20px;
    }

    .step-focus-close {
        right: 12px;
        top: 12px;
    }
}
    </style>
@endsection

@section('content')
    @php
        $editingCartItemId = session('editing_cart_item_id');
        $editingCartItem = session('editing_cart_item');

        $editingOptions = collect($editingCartItem['options'] ?? [])
            ->pluck('option_id', 'group_id')
            ->toArray();

        $editingVariants = collect($editingCartItem['options'] ?? [])
            ->filter(fn($item) => !empty($item['variant_id']))
            ->pluck('variant_id', 'option_id')
            ->toArray();

        $editingCustomColors = collect($editingCartItem['custom_colors'] ?? [])
            ->pluck('value', 'group_id')
            ->toArray();

        $defaultQuantity = old('quantity', $editingCartItem['quantity'] ?? 100);

        $basePrice = 0;
    @endphp


    <section class="customize-hero-section">
        <div class="container">
            <div class="hotstrap-breadcrumb">
                <a href="{{ route('products.index') }}"><img src="{{ asset('assets/images/icon/home.png') }}"
                        alt="Home"></a>
                <span>/</span>

                @if ($product->category)
                    <span>{{ $product->category->category_name }}</span>
                    <span>/</span>
                @endif

                <span>{{ $product->product_name }}</span>
            </div>
            <div class="customize-hero-banner">
                @if ($product->detail && $product->detail->sample_image)
                    <img src="{{ asset('storage/' . $product->detail->sample_image) }}" alt="{{ $product->product_name }}">
                @else
                    <img src="{{ asset('images/no-image.png') }}" alt="No image">
                @endif


            </div>



            <div class="customize-layout">

                <div class="customize-options">

                    <form action="{{ route('cart.add') }}" method="POST" id="customize-form" novalidate>
                        @csrf


                        <input type="hidden" name="product_id" value="{{ $product->product_id }}">

                        @if ($editingCartItemId)
                            <input type="hidden" name="cart_item_id" value="{{ $editingCartItemId }}">
                        @endif

                        <input type="hidden" name="product_id" value="{{ $product->product_id }}">
                        @csrf

                        @forelse($optionGroups as $displayGroupId => $options)
                            @php
                                $firstOption = $options->first();

                                // group จริงของ option อาจเป็น child group
                                $realGroup = $firstOption?->group;

                                // ถ้ามี parent ให้ใช้ parent เป็นหัวข้อหลัก
                                $group = $realGroup?->parent ?: $realGroup;

                                $groupName = $group->group_name ?? 'Other';
                                $displayType = $group->display_type ?? 'button';
                                $isRequired = $group->is_required ?? true;
                            @endphp

                            <div class="customize-option-group" data-group-id="{{ $group->option_group_id }}"
                                data-required="{{ $isRequired ? 1 : 0 }}">
                                <h2>
                                    <span class="visible-group-number"></span>. {{ $groupName }}

                                    @if ($isRequired)
                                        <span class="required">*</span>
                                    @endif

                                    @if (!empty($group->help_text))
                                        <button type="button" class="info-popover-btn" data-bs-toggle="popover"
                                            data-bs-trigger="click" data-bs-placement="top"
                                            data-bs-content="{{ $group->help_text }}">
                                            ⓘ
                                        </button>
                                    @endif
                                </h2>

                                @if ($displayType === 'image_card')
                                    <div class="option-image-grid">
                                        @foreach ($options as $option)
                                            <label class="option-image-card">
                                                <input type="radio" name="options[{{ $option->option_group_id }}]"
                                                    value="{{ $option->option_id }}" data-group-name="{{ $groupName }}"
                                                    class="js-option-input" data-option-name="{{ $option->option_name }}"
                                                    data-price="{{ $option->additional_price ?? 0 }}"
                                                    data-price-type="{{ $option->price_type }}"
                                                    data-option-id="{{ $option->option_id }}"
                                                    {{ old("options.{$option->option_group_id}", $editingOptions[$option->option_group_id] ?? null) == $option->option_id || (!$editingCartItem && $option->pivot->is_default) ? 'checked' : '' }}>

                                                <div class="option-image-box">
                                                    @if ($option->mainImage)
                                                        <img src="{{ asset('storage/' . $option->mainImage->image_path) }}"
                                                            alt="{{ $option->option_name }}">
                                                    @else
                                                        <img src="{{ asset('images/no-image.png') }}" alt="No image">
                                                    @endif
                                                </div>

                                                <span>{{ $option->option_name }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                @elseif($displayType === 'image_card_variant')
                                    <div class="option-variant-grid">
                                        @foreach ($options as $option)
                                    
                                            @php
                                                $defaultVariant =
                                                    $option->variants->firstWhere('is_default', 1) ??
                                                    $option->variants->first();

                                                $defaultImage =
                                                    $defaultVariant && $defaultVariant->image_path
                                                        ? asset('storage/' . $defaultVariant->image_path)
                                                        : ($option->mainImage
                                                            ? asset('storage/' . $option->mainImage->image_path)
                                                            : asset('images/no-image.png'));
                                            @endphp

                                            <div class="option-variant-card">
                                                <input type="radio" name="options[{{ $option->option_group_id }}]"
                                                    value="{{ $option->option_id }}" data-group-name="{{ $groupName }}"
                                                    class="js-option-input" data-option-name="{{ $option->option_name }}"
                                                    data-price="{{ $option->additional_price ?? 0 }}"
                                                    data-price-type="{{ $option->price_type }}"
                                                    data-option-id="{{ $option->option_id }}"
                                                    {{ old("options.{$option->option_group_id}", $editingOptions[$option->option_group_id] ?? null) == $option->option_id || (!$editingCartItem && $option->pivot->is_default) ? 'checked' : '' }}>

                                                <span class="variant-title">
                                                    {{ $option->option_name }}
                                                </span>

                                                <div class="variant-image-box">
                                                    <img src="{{ $defaultImage }}" alt="{{ $option->option_name }}"
                                                        class="variant-main-image">
                                                </div>

                                                @if ($option->variants && $option->variants->count())
                                                    @php
                                                        $editingVariantId =
                                                            $editingVariants[$option->option_id] ?? null;

                                                        $selectedVariant = $editingVariantId
                                                            ? $option->variants->firstWhere(
                                                                'variant_id',
                                                                $editingVariantId,
                                                            )
                                                            : $defaultVariant;

                                                        $selectedVariant = $selectedVariant ?? $defaultVariant;
                                                    @endphp



                                                    <select name="variants[{{ $option->option_id }}]"
                                                        class="variant-select js-variant-select">
                                                        @foreach ($option->variants as $variant)
                                                            <option value="{{ $variant->variant_id }}"
                                                                data-variant-name="{{ $variant->variant_name }}"
                                                                data-image="{{ $variant->image_path ? asset('storage/' . $variant->image_path) : $defaultImage }}"
                                                                data-price="{{ $variant->additional_price ?? 0 }}"
                                                                {{ $selectedVariant && (int) $selectedVariant->variant_id === (int) $variant->variant_id ? 'selected' : '' }}>
                                                                {{ $variant->variant_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                @elseif($displayType === 'image_grid_compact')
                                    <div class="option-compact-grid">
                                        @foreach ($options as $option)
                                            <label class="option-compact-card">
                                                <input type="radio" name="options[{{ $option->option_group_id }}]"
                                                    value="{{ $option->option_id }}" data-group-name="{{ $groupName }}"
                                                    class="js-option-input" data-option-name="{{ $option->option_name }}"
                                                    data-price="{{ $option->additional_price ?? 0 }}"
                                                    data-price-type="{{ $option->price_type }}"
                                                    data-option-id="{{ $option->option_id }}"
                                                    {{ old("options.{$option->option_group_id}", $editingOptions[$option->option_group_id] ?? null) == $option->option_id || (!$editingCartItem && $option->pivot->is_default) ? 'checked' : '' }}>

                                                <div class="option-compact-image">
                                                    @if ($option->mainImage)
                                                        <img src="{{ asset('storage/' . $option->mainImage->image_path) }}"
                                                            alt="{{ $option->option_name }}">
                                                    @else
                                                        <img src="{{ asset('images/no-image.png') }}" alt="No image">
                                                    @endif
                                                </div>

                                                <div class="option-compact-name">
                                                    {{ $option->option_name }}
                                                </div>

                                                @if (($option->additional_price ?? 0) > 0)
                                                    <div class="option-compact-price">
                                                        +¥ {{ number_format($option->additional_price, 2) }}
                                                    </div>
                                                @else
                                                    <div class="option-compact-price free">
                                                        Free
                                                    </div>
                                                @endif
                                            </label>
                                        @endforeach
                                    </div>

                                    @if ($options->count() > 8)
                                        <div class="option-view-more-wrap">
                                            <button type="button" class="option-view-more-btn">
                                                View More
                                            </button>
                                        </div>
                                    @endif
                                @elseif($displayType === 'color')
                                    <div class="option-color-list">
                                        @foreach ($options as $option)
                                            <label class="option-color-item" title="{{ $option->option_name }}">
                                                <input type="radio" name="options[{{ $option->option_group_id }}]"
                                                    value="{{ $option->option_id }}" class="js-option-input"
                                                    data-group-name="{{ $groupName }}"
                                                    data-option-name="{{ $option->option_name }}"
                                                    data-price="{{ $option->additional_price ?? 0 }}"
                                                    data-price-type="{{ $option->price_type }}"
                                                    data-option-id="{{ $option->option_id }}"
                                                    {{ old("options.{$option->option_group_id}", $editingOptions[$option->option_group_id] ?? null) == $option->option_id || (!$editingCartItem && $option->pivot->is_default) ? 'checked' : '' }}>

                                                <span class="color-circle"
                                                    style="background: {{ $option->color_code ?: '#ffffff' }};"></span>
                                            </label>
                                        @endforeach

                                        <button type="button" class="add-color-btn"
                                            data-group-id="{{ $firstOption->option_group_id }}"
                                            data-group-name="{{ $groupName }}">
                                            +
                                        </button>
                                    </div>

                                    <div class="custom-color-box"
                                        id="custom-color-box-{{ $firstOption->option_group_id }}" style="display:none;">
                                        <label class="custom-color-label">
                                            Special Cord Colors
                                            @if ($isRequired)
                                                <span class="required">*</span>
                                            @endif
                                            <span class="info-icon">ⓘ</span>
                                        </label>

                                        <div class="custom-color-input-row">
                                            <input type="text"
                                                name="custom_colors[{{ $firstOption->option_group_id }}]"
                                                class="custom-color-input js-custom-color-input"
                                                data-group-name="Special Cord Colors"
                                                placeholder="Please specify Pantone color.">

                                            <button type="button" class="custom-color-add-btn">
                                                Add
                                            </button>
                                        </div>
                                    </div>
                                @elseif($displayType === 'select_detail')
                                    @php
                                        $defaultOption =
                                            $options->firstWhere('pivot.is_default', 1) ?? $options->first();

                                        $defaultImage =
                                            $defaultOption && $defaultOption->mainImage
                                                ? asset('storage/' . $defaultOption->mainImage->image_path)
                                                : '';

                                        $defaultDetail = $defaultOption->option_detail ?? '';

                                        $hasDefaultImage = !empty($defaultImage);
                                        $hasDefaultDetail = !empty(trim(strip_tags($defaultDetail)));
                                    @endphp

                                    <div class="option-select-detail-wrap">
                                        <select name="options[{{ $defaultOption->option_group_id }}]"
                                            class="option-select-detail js-option-input"
                                            data-group-name="{{ $groupName }}">
                                            @foreach ($options as $option)
                                                @php
                                                    $imagePath = $option->mainImage
                                                        ? asset('storage/' . $option->mainImage->image_path)
                                                        : '';
                                                @endphp

                                                <option value="{{ $option->option_id }}"
                                                    data-option-id="{{ $option->option_id }}"
                                                    data-option-name="{{ $option->option_name }}"
                                                    data-price="{{ $option->additional_price ?? 0 }}"
                                                    data-price-type="{{ $option->price_type }}"
                                                    data-image="{{ $imagePath }}"
                                                    data-detail="{{ e($option->option_detail ?? '') }}"
                                                    {{ old("options.{$option->option_group_id}", $editingOptions[$option->option_group_id] ?? null) == $option->option_id || (!$editingCartItem && $option->pivot->is_default) ? 'selected' : '' }}>
                                                    {{ $option->option_name }}
                                                </option>
                                            @endforeach
                                        </select>

                                        <div class="select-detail-preview"
                                            style="{{ !$hasDefaultImage && !$hasDefaultDetail ? 'display:none;' : '' }}">
                                            <div class="select-detail-image-box"
                                                style="{{ !$hasDefaultImage ? 'display:none;' : '' }}">
                                                <img class="select-detail-image" src="{{ $defaultImage }}"
                                                    alt="{{ $defaultOption->option_name ?? '' }}">
                                            </div>

                                            <div class="select-detail-text-box"
                                                style="{{ !$hasDefaultDetail ? 'display:none;' : '' }}">
                                                {!! nl2br(e($defaultDetail)) !!}
                                            </div>
                                        </div>
                                    </div>
                                @elseif($displayType === 'grouped_buttons')
                                    @php
                                        $childGroups = $options->groupBy(function ($option) {
                                            return $option->group->option_group_id ?? 0;
                                        });
                                    @endphp

                                    <div class="grouped-buttons-wrapper">
                                        @foreach ($childGroups as $childGroupId => $childOptions)
                                            @php
                                                $childGroup = $childOptions->first()?->group;
                                                $childGroupName = $childGroup->group_name ?? 'Option';
                                            @endphp

                                            <div class="grouped-button-set"
                                                data-group-id="{{ $childGroup->option_group_id }}">
                                                <div class="grouped-button-title">
                                                    <span>{{ $childGroupName }}</span>

                                                    @if (!empty($childGroup->help_text))
                                                        <button type="button" class="info-popover-btn"
                                                            data-bs-toggle="popover" data-bs-trigger="click"
                                                            data-bs-placement="top"
                                                            data-bs-content="{{ $childGroup->help_text }}">
                                                            ⓘ
                                                        </button>
                                                    @endif
                                                </div>

                                                <div class="option-button-list">
                                                    @foreach ($childOptions as $option)
                                                        <label class="option-button-item">
                                                            <input type="radio"
                                                                name="options[{{ $childGroup->option_group_id }}]"
                                                                value="{{ $option->option_id }}" class="js-option-input"
                                                                data-group-name="{{ $childGroupName }}"
                                                                data-option-name="{{ $option->option_name }}"
                                                                data-price="{{ $option->additional_price ?? 0 }}"
                                                                data-price-type="{{ $option->price_type }}"
                                                                data-option-id="{{ $option->option_id }}"
                                                                {{ old("options.{$option->option_group_id}", $editingOptions[$option->option_group_id] ?? null) == $option->option_id || (!$editingCartItem && $option->pivot->is_default) ? 'checked' : '' }}>

                                                            <span>{{ $option->option_name }}</span>
                                                        </label>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @elseif($displayType === 'previous_order_design')
                                    @php
                                        $defaultOption =
                                            $options->firstWhere('pivot.is_default', 1) ?? $options->first();

                                        $selectedOptionId = old(
                                            "options.{$firstOption->option_group_id}",
                                            $editingOptions[$firstOption->option_group_id] ??
                                                ($defaultOption->option_id ?? null),
                                        );

                                        $yesOption = $options->first(function ($option) {
                                            return strtolower(trim($option->option_name)) === 'yes';
                                        });

                                        $previousOrderValue = old(
                                            "previous_order_no.{$firstOption->option_group_id}",
                                            $editingCartItem['previous_order_no'][$firstOption->option_group_id] ?? '',
                                        );
                                    @endphp

                                    <div class="previous-order-box">
                                        <div class="previous-order-choice-list">
                                            @foreach ($options as $option)
                                                <label class="previous-order-choice">
                                                    <input type="radio" name="options[{{ $option->option_group_id }}]"
                                                        value="{{ $option->option_id }}"
                                                        class="js-option-input previous-order-radio"
                                                        data-group-name="{{ $groupName }}"
                                                        data-option-name="{{ $option->option_name }}"
                                                        data-price="{{ $option->additional_price ?? 0 }}"
                                                        data-price-type="{{ $option->price_type }}"
                                                        data-option-id="{{ $option->option_id }}"
                                                        data-is-yes="{{ in_array(strtolower(trim($option->option_name)), ['yes', 'sim']) ? 1 : 0 }}"
                                                        {{ (int) $selectedOptionId === (int) $option->option_id ? 'checked' : '' }}>

                                                    <span>{{ $option->option_name }}</span>
                                                </label>
                                            @endforeach
                                        </div>

                                        <div class="previous-order-input-box {{ $yesOption && (int) $selectedOptionId === (int) $yesOption->option_id ? 'is-open' : '' }}"
                                            data-previous-order-box="{{ $firstOption->option_group_id }}">
                                            <label>
                                                Previous Order No.
                                                @if ($isRequired)
                                                    <span class="required">*</span>
                                                @endif
                                            </label>

                                            <input type="text"
                                                name="previous_order_no[{{ $firstOption->option_group_id }}]"
                                                class="previous-order-input" value="{{ $previousOrderValue }}"
                                                placeholder="Ex: ORD202605110001">
                                        </div>
                                    </div>
                                @else
                                    <div class="option-button-list">
                                        @foreach ($options as $option)
                                            <label class="option-button-item">
                                                <input type="radio" name="options[{{ $option->option_group_id }}]"
                                                    value="{{ $option->option_id }}" class="js-option-input"
                                                    data-group-name="{{ $groupName }}"
                                                    data-option-name="{{ $option->option_name }}"
                                                    data-price="{{ $option->additional_price ?? 0 }}"
                                                    data-price-type="{{ $option->price_type }}"
                                                    data-option-id="{{ $option->option_id }}"
                                                    {{ old("options.{$option->option_group_id}", $editingOptions[$option->option_group_id] ?? null) == $option->option_id || (!$editingCartItem && $option->pivot->is_default) ? 'checked' : '' }}>

                                                <span>{{ $option->option_name }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        @empty
                            <div class="no-options">
                                No options assigned to this product.
                            </div>
                        @endforelse
                        <div class="quantity-add-cart-section">
                            <div class="quantity-label-row">
                                <label for="quantity">{{ __('product.product_detail.Quantity') }}</label>

                                <span class="minimum-note">
                                    ** {{ __('product.product_detail.minimum_order') }} **
                                </span>
                            </div>

                            <div class="quantity-input-row">
                                <input type="number" name="quantity" id="quantity" value="{{ $defaultQuantity }}"
                                    min="20" step="1" required>

                                <span>{{ __('product.product_detail.unit') }}</span>
                            </div>

                            @error('quantity')
                                <div style="color:red; margin-top:8px;">
                                    {{ $message }}
                                </div>
                            @enderror

                            <button type="submit" class="add-to-cart-btn">
                                {{ $editingCartItemId ? __('product.product_detail.update_cart') : __('product.product_detail.add_to_cart') }}
                            </button>
                        </div>
                    </form>
                </div>

                <aside class="product-summary-box">
                    <h3>{{ __('product.product_detail.summary_product') }}</h3>

                    {{-- <div class="summary-item">
                        <span>Unit Price</span>
                        <strong>¥ <span id="summary-unit-price">{{ number_format($basePrice, 2) }}</span></strong>
                    </div> --}}

                    {{-- <div class="summary-item">
                        <span>Quantity</span>
                        <strong><span id="summary-quantity">{{ old('quantity', 100) }}</span> Unidades</strong>
                    </div> --}}

                    <div class="summary-divider"></div>

                    <div id="summary-options"></div>

                    <div class="summary-divider"></div>

                    <div class="summary-total">
                        <span>{{ __('product.product_detail.Total') }}:</span>
                        <strong>¥ <span id="total-price">{{ number_format($basePrice, 2) }}</span></strong>
                    </div>
                </aside>

            </div>


        </div>
        <div class="step-focus-overlay" id="stepFocusOverlay"></div>

<button type="button" class="step-focus-close" id="stepFocusClose">
    ×
</button>

<div class="step-bottom-bar" id="stepBottomBar">
    <div class="step-bottom-bar-left">
        <button type="button" class="step-bar-btn step-bar-btn-prev" id="stepPrevBtn">
            {{ __('product.product_detail.prev_step') }}
        </button>
    </div>

    <div class="step-bottom-bar-center">
        <div class="step-total-main">
            <span id="stepBarTotalPrice">0.00</span> ¥ (Total)
        </div>
        <div class="step-total-sub">
            <span id="stepBarPerPrice">0.00</span> ¥ {{ __('product.product_detail.per_price') }}
        </div>
    </div>

    <div class="step-bottom-bar-right">
        <button type="button" class="step-bar-btn step-bar-btn-next" id="stepNextBtn">
            {{ __('product.product_detail.next_step') }}
        </button>
    </div>
</div>
    </section>


@endsection

@section('js')
    <script>
        const priceRules = @json($priceRules ?? []);
        const optionDependencies = @json($dependencies ?? []);

        console.log('priceRules:', priceRules);

        let isUpdatingDependencies = false;

        function formatPrice(price) {
            return Number(price || 0).toFixed(2);
        }

        function getSelectedOptionIdsForPrice() {
            const selected = [];

            document.querySelectorAll('#customize-form input[type="radio"]:checked').forEach(function(input) {
                const optionId = parseInt(input.value);

                if (optionId) {
                    selected.push(optionId);
                }
            });

            document.querySelectorAll('#customize-form select.option-select-detail').forEach(function(select) {
                if (select.closest('.customize-option-group')?.style.display === 'none') {
                    return;
                }

                const optionId = parseInt(select.value);

                if (optionId) {
                    selected.push(optionId);
                }
            });

            return selected;
        }

        function findMatchedPriceRule(selectedOptionIds) {
            const matchedRules = priceRules.filter(function(rule) {
                const ruleOptionIds = rule.option_ids || [];

                if (!ruleOptionIds.length) {
                    return false;
                }

                return ruleOptionIds.every(function(optionId) {
                    return selectedOptionIds.includes(parseInt(optionId));
                });
            });

            if (!matchedRules.length) {
                return null;
            }

            matchedRules.sort(function(a, b) {
                return (b.option_ids || []).length - (a.option_ids || []).length;
            });

            return matchedRules[0];
        }

        function getUnitPriceFromRule(rule, quantity) {
            quantity = parseInt(quantity || 0);

            if (!rule || !quantity || quantity <= 0) {
                return 0;
            }

            const tiers = rule.tiers || [];

            const matchedTier = tiers.find(function(tier) {
                const minQty = parseInt(tier.min_qty);
                const maxQty = tier.max_qty === null ? null : parseInt(tier.max_qty);

                return quantity >= minQty && (maxQty === null || quantity <= maxQty);
            });

            if (matchedTier) {
                return parseFloat(matchedTier.unit_price);
            }

            const sortedTiers = [...tiers].sort(function(a, b) {
                return parseInt(b.min_qty) - parseInt(a.min_qty);
            });

            const highestTier = sortedTiers[0];

            if (highestTier && quantity > parseInt(highestTier.min_qty)) {
                return parseFloat(highestTier.unit_price);
            }

            return 0;
        }

        function isOptionInMatchedRule(optionId, matchedRule) {
            if (!matchedRule || !matchedRule.option_ids) {
                return false;
            }

            return matchedRule.option_ids
                .map(function(id) {
                    return parseInt(id);
                })
                .includes(parseInt(optionId));
        }

        function updateSingleSelectDetailPreview(select) {
            const selected = select.options[select.selectedIndex];
            const wrap = select.closest('.option-select-detail-wrap');

            if (!wrap || !selected) {
                return;
            }

            const preview = wrap.querySelector('.select-detail-preview');
            const imageBox = wrap.querySelector('.select-detail-image-box');
            const textBox = wrap.querySelector('.select-detail-text-box');
            const image = wrap.querySelector('.select-detail-image');

            if (!preview) {
                return;
            }

            const imageUrl = selected.dataset.image || '';
            const detailText = selected.dataset.detail || '';

            const hasImage = imageUrl.trim() !== '';
            const hasDetail = detailText.trim() !== '';

            if (!hasImage && !hasDetail) {
                preview.style.display = 'none';

                if (image) {
                    image.src = '';
                }

                if (textBox) {
                    textBox.innerHTML = '';
                }

                return;
            }

            preview.style.display = '';

            if (imageBox) {
                imageBox.style.display = hasImage ? '' : 'none';
            }

            if (image) {
                image.src = hasImage ? imageUrl : '';
                image.alt = selected.dataset.optionName || '';
            }

            if (textBox) {
                textBox.style.display = hasDetail ? '' : 'none';
                textBox.innerHTML = hasDetail ? detailText.replace(/\n/g, '<br>') : '';
            }
        }

        function updateSummary() {
            const quantityInput = document.getElementById('quantity');
            const quantity = parseInt(quantityInput?.value || 0);

            const selectedOptionIds = getSelectedOptionIdsForPrice();
            console.log('selectedOptionIds:', selectedOptionIds);

            const matchedRule = findMatchedPriceRule(selectedOptionIds);
            const unitPrice = getUnitPriceFromRule(matchedRule, quantity);
            const productTotal = unitPrice * quantity;

            let optionTotal = 0;
            let html = '';

            const summaryOptions = document.getElementById('summary-options');
            const checkedOptions = document.querySelectorAll('#customize-form input[type="radio"]:checked');
            const selectedOptions = document.querySelectorAll('#customize-form .option-select-detail');
            const customColorInputs = document.querySelectorAll('.custom-color-input');

            // if (matchedRule) {
            //     html += `
        //         <div class="summary-item">
        //             <span>Price Rule</span>
        //             <strong>${matchedRule.rule_name || 'Matched Rule'}</strong>
        //         </div>
        //     `;
            // } else {
            //     html += `
        //         <div class="summary-item">
        //             <span>Price Rule</span>
        //             <strong style="color:#dc2626;">No matched price rule</strong>
        //         </div>
        //     `;
            // }

            checkedOptions.forEach(function(input) {
                const groupEl = input.closest('.customize-option-group, .grouped-button-set');

                if (groupEl && groupEl.style.display === 'none') {
                    return;
                }

                const optionId = parseInt(input.value);

                const groupName = input.dataset.groupName || '';
                const optionName = input.dataset.optionName || '';
                const variantName = input.dataset.variantName || '';
                const price = parseFloat(input.dataset.price || 0);
                const variantPrice = parseFloat(input.dataset.variantPrice || 0);
                const priceType = input.dataset.priceType || 'per_order';

                const isRuleOption = isOptionInMatchedRule(optionId, matchedRule);

                if (!isRuleOption) {
                    if (priceType === 'per_item') {
                        optionTotal += (price + variantPrice) * quantity;
                    } else {
                        optionTotal += price + variantPrice;
                    }
                }

                const displayName = variantName ?
                    `${optionName} - ${variantName}` :
                    optionName;

                let extraText = '';

                if (input.classList.contains('previous-order-radio') && input.dataset.isYes === '1') {
                    const groupId = input.name.match(/\[(.*?)\]/)?.[1];

                    const previousInput = document.querySelector(
                        '[data-previous-order-box="' + groupId + '"] .previous-order-input'
                    );

                    if (previousInput && previousInput.value.trim()) {
                        extraText = `<br><small>Order No: ${previousInput.value.trim()}</small>`;
                    }
                }

                html += `
    <div class="summary-item">
        <span>${groupName}</span>
        <strong>${displayName}${extraText}</strong>
    </div>
`;
            });

            selectedOptions.forEach(function(select) {
                const groupEl = select.closest('.customize-option-group, .grouped-button-set');

                if (groupEl && groupEl.style.display === 'none') {
                    return;
                }

                const selected = select.options[select.selectedIndex];

                if (!selected || selected.disabled || selected.hidden || !selected.value) {
                    return;
                }

                const optionId = parseInt(selected.value);

                const groupName = select.dataset.groupName || '';
                const optionName = selected.dataset.optionName || selected.textContent || '';
                const price = parseFloat(selected.dataset.price || 0);
                const priceType = selected.dataset.priceType || 'per_order';

                const isRuleOption = isOptionInMatchedRule(optionId, matchedRule);

                if (!isRuleOption) {
                    if (priceType === 'per_item') {
                        optionTotal += price * quantity;
                    } else {
                        optionTotal += price;
                    }
                }

                html += `
                <div class="summary-item">
                    <span>${groupName}</span>
                    <strong>${optionName}</strong>
                </div>
            `;
            });

            customColorInputs.forEach(function(input) {
                const value = input.value.trim();

                if (!value) {
                    return;
                }

                const groupName = input.dataset.groupName || 'Special Cord Colors';

                html += `
                <div class="summary-item">
                    <span>${groupName}</span>
                    <strong>${value}</strong>
                </div>
            `;
            });

            const total = productTotal + optionTotal;

            // if (document.getElementById('summary-unit-price')) {
            //     document.getElementById('summary-unit-price').innerText = formatPrice(unitPrice);
            // }

            // if (document.getElementById('summary-quantity')) {
            //     document.getElementById('summary-quantity').innerText = quantity;
            // }

            if (summaryOptions) {
                summaryOptions.innerHTML = html;
            }

            if (document.getElementById('total-price')) {
                document.getElementById('total-price').innerText = formatPrice(total);
            }
            if (document.getElementById('stepBarTotalPrice')) {
    document.getElementById('stepBarTotalPrice').innerText = formatPrice(total);
}

if (document.getElementById('stepBarPerPrice')) {
    document.getElementById('stepBarPerPrice').innerText = formatPrice(unitPrice);
}
        }

        function getSelectedOptionIds() {
            const selected = [];

            document.querySelectorAll('#customize-form input[type="radio"]:checked').forEach(function(input) {
                const optionId = parseInt(input.value);

                if (optionId) {
                    selected.push(optionId);
                }
            });

            document.querySelectorAll('#customize-form select.option-select-detail').forEach(function(select) {
                const optionId = parseInt(select.value);

                if (optionId) {
                    selected.push(optionId);
                }
            });

            return selected;
        }

        function clearInputsInside(element) {
            if (!element) {
                return;
            }

            element.querySelectorAll('input[type="radio"]').forEach(function(input) {
                input.checked = false;
            });

            element.querySelectorAll('input[type="text"]').forEach(function(input) {
                input.value = '';
            });

            element.querySelectorAll('select').forEach(function(select) {
                select.selectedIndex = 0;
                updateSingleSelectDetailPreview(select);
            });
        }

        function getActiveDependencyTargetGroupIds() {
            const selectedOptionIds = getSelectedOptionIds();
            const activeGroupIds = [];

            optionDependencies.forEach(function(dep) {
                const triggerOptionId = parseInt(dep.parent_option_id);

                if (!selectedOptionIds.includes(triggerOptionId)) {
                    return;
                }

                if (dep.target_type === 'group' && dep.target_group_id) {
                    activeGroupIds.push(parseInt(dep.target_group_id));
                }
            });

            return activeGroupIds;
        }

        function hideDependentGroups() {
            const activeGroupIds = getActiveDependencyTargetGroupIds();

            const targetGroupIds = [
                ...new Set(
                    optionDependencies
                    .filter(function(dep) {
                        return dep.target_type === 'group' && dep.target_group_id;
                    })
                    .map(function(dep) {
                        return parseInt(dep.target_group_id);
                    })
                )
            ];

            targetGroupIds.forEach(function(groupId) {
                const groupEls = document.querySelectorAll('[data-group-id="' + groupId + '"]');

                groupEls.forEach(function(groupEl) {
                    if (activeGroupIds.includes(parseInt(groupId))) {
                        groupEl.style.display = '';
                        return;
                    }

                    groupEl.style.display = 'none';
                    clearInputsInside(groupEl);
                });
            });
        }

        function hideDependentOptions() {
            const targetOptionIds = [
                ...new Set(
                    optionDependencies
                    .filter(function(dep) {
                        return dep.target_type === 'option' && dep.target_option_id;
                    })
                    .map(function(dep) {
                        return parseInt(dep.target_option_id);
                    })
                )
            ];

            targetOptionIds.forEach(function(optionId) {
                const radioInputs = document.querySelectorAll(
                    '#customize-form input[type="radio"][data-option-id="' + optionId + '"]'
                );

                radioInputs.forEach(function(input) {
                    const optionBox = input.closest('label');

                    if (optionBox) {
                        optionBox.style.display = 'none';
                    }

                    input.checked = false;
                });

                const selectOptions = document.querySelectorAll(
                    '#customize-form select.option-select-detail option[data-option-id="' + optionId + '"]'
                );

                selectOptions.forEach(function(option) {
                    option.hidden = true;
                    option.disabled = true;

                    const select = option.closest('select');

                    if (select && select.value == option.value) {
                        const firstVisibleOption = Array.from(select.options).find(function(item) {
                            return item.value && !item.disabled && !item.hidden;
                        });

                        if (firstVisibleOption) {
                            select.value = firstVisibleOption.value;
                        } else {
                            select.value = '';
                        }

                        updateSingleSelectDetailPreview(select);
                    }
                });
            });
        }

        function showMatchedDependencies() {
            const selectedOptionIds = getSelectedOptionIds();

            optionDependencies.forEach(function(dep) {
                const triggerOptionId = parseInt(dep.parent_option_id);

                if (!selectedOptionIds.includes(triggerOptionId)) {
                    return;
                }

                if (dep.target_type === 'group' && dep.target_group_id) {
                    const groupEls = document.querySelectorAll('[data-group-id="' + dep.target_group_id + '"]');

                    groupEls.forEach(function(groupEl) {
                        groupEl.style.display = '';
                    });
                }

                if (dep.target_type === 'option' && dep.target_option_id) {
                    const optionId = parseInt(dep.target_option_id);

                    const radioInputs = document.querySelectorAll(
                        '#customize-form input[type="radio"][data-option-id="' + optionId + '"]'
                    );

                    radioInputs.forEach(function(input) {
                        const optionBox = input.closest('label');

                        if (optionBox) {
                            optionBox.style.display = '';
                        }
                    });

                    const selectOptions = document.querySelectorAll(
                        '#customize-form select.option-select-detail option[data-option-id="' + optionId + '"]'
                    );

                    selectOptions.forEach(function(option) {
                        option.hidden = false;
                        option.disabled = false;
                    });
                }
            });
        }

        function fixSelectDetailAfterDependency() {
            document.querySelectorAll('#customize-form select.option-select-detail').forEach(function(select) {
                const groupEl = select.closest('.customize-option-group');

                if (groupEl && groupEl.style.display === 'none') {
                    return;
                }

                const selectedOption = select.options[select.selectedIndex];

                const selectedIsInvalid = !selectedOption ||
                    selectedOption.disabled ||
                    selectedOption.hidden ||
                    !selectedOption.value;

                if (selectedIsInvalid) {
                    const firstVisibleOption = Array.from(select.options).find(function(option) {
                        return option.value && !option.disabled && !option.hidden;
                    });

                    if (firstVisibleOption) {
                        select.value = firstVisibleOption.value;
                        updateSingleSelectDetailPreview(select);
                    } else {
                        select.value = '';

                        const wrap = select.closest('.option-select-detail-wrap');
                        const preview = wrap?.querySelector('.select-detail-preview');

                        if (preview) {
                            preview.style.display = 'none';
                        }
                    }

                    return;
                }

                updateSingleSelectDetailPreview(select);
            });
        }

        function updateOptionDependencies() {
    if (isUpdatingDependencies) {
        return;
    }

    isUpdatingDependencies = true;

    hideDependentGroups();
    hideDependentOptions();
    showMatchedDependencies();
    fixSelectDetailAfterDependency();

    applyRequiredRules();
    updateVisibleGroupNumbers();

    isUpdatingDependencies = false;

    updateSummary();

    if (typeof refreshStepModeAfterDependencyChange === 'function') {
        refreshStepModeAfterDependencyChange();
    }
}
        function updateVisibleGroupNumbers() {
            let number = 1;

            document.querySelectorAll('.customize-option-group').forEach(function(groupEl) {
                const isVisible = groupEl.style.display !== 'none';

                const numberEl = groupEl.querySelector('.visible-group-number');

                if (!numberEl) {
                    return;
                }

                if (isVisible) {
                    numberEl.innerText = number;
                    number++;
                }
            });
        }

        function applyRequiredRules() {
            document.querySelectorAll('.customize-option-group').forEach(function(groupEl) {
                const radios = groupEl.querySelectorAll('input[type="radio"].js-option-input');
                const selects = groupEl.querySelectorAll('select.js-option-input');
                const customInputs = groupEl.querySelectorAll('.js-custom-color-input');

                radios.forEach(function(radio) {
                    radio.required = false;
                });

                selects.forEach(function(select) {
                    select.required = false;
                });

                customInputs.forEach(function(input) {
                    input.required = false;
                });
            });
        }

        function clearRequiredErrors() {
            document.querySelectorAll('.customize-option-group').forEach(function(groupEl) {
                groupEl.classList.remove('has-error');

                const oldError = groupEl.querySelector('.option-required-error');

                if (oldError) {
                    oldError.remove();
                }
            });
        }

        function showRequiredError(groupEl, message) {
            groupEl.classList.add('has-error');

            let errorBox = groupEl.querySelector('.option-required-error');

            if (!errorBox) {
                errorBox = document.createElement('div');
                errorBox.className = 'option-required-error';
                errorBox.textContent = message;

                const h2 = groupEl.querySelector('h2');

                if (h2) {
                    h2.insertAdjacentElement('afterend', errorBox);
                } else {
                    groupEl.prepend(errorBox);
                }
            }
        }

        function validateRequiredOptions() {
            clearRequiredErrors();

            const requiredGroups = document.querySelectorAll('.customize-option-group[data-required="1"]');

            for (const groupEl of requiredGroups) {
                if (groupEl.style.display === 'none') {
                    continue;
                }

                const visibleRadios = Array.from(
                    groupEl.querySelectorAll('input[type="radio"].js-option-input')
                ).filter(function(radio) {
                    const label = radio.closest('label');
                    return !label || label.style.display !== 'none';
                });

                const visibleSelects = Array.from(
                    groupEl.querySelectorAll('select.js-option-input')
                ).filter(function(select) {
                    return select.offsetParent !== null;
                });

                const customColorInput = groupEl.querySelector('.js-custom-color-input');
                const customColorBox = customColorInput ? customColorInput.closest('.custom-color-box') : null;
                const customColorVisible = customColorBox && customColorBox.style.display !== 'none';
                const hasCustomColorValue = customColorVisible && customColorInput.value.trim() !== '';

                let isValid = true;

                if (visibleRadios.length > 0) {
                    const radioNames = [...new Set(
                        visibleRadios.map(function(radio) {
                            return radio.name;
                        })
                    )];

                    for (const name of radioNames) {
                        const checked = groupEl.querySelector(
                            'input[type="radio"][name="' + name + '"]:checked'
                        );

                        if (!checked && !hasCustomColorValue) {
                            isValid = false;
                            break;
                        }
                    }
                }

                for (const select of visibleSelects) {
                    if (!select.value) {
                        isValid = false;
                        break;
                    }
                }

                if (!isValid) {
                    showRequiredError(groupEl, 'Please select this required option.');

                    groupEl.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });

                    return false;
                }
            }
            const previousOrderBoxes = document.querySelectorAll('.previous-order-input-box.is-open');

            for (const box of previousOrderBoxes) {
                const input = box.querySelector('.previous-order-input');
                const groupEl = box.closest('.customize-option-group');

                if (input && input.required && !input.value.trim()) {
                    showRequiredError(groupEl, 'Please enter your previous order number.');

                    groupEl.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });

                    return false;
                }
            }

            return true;
        }

        document.addEventListener('DOMContentLoaded', function() {
            const quantityInput = document.getElementById('quantity');

            document.querySelectorAll('#customize-form input[type="radio"]').forEach(function(input) {
                input.addEventListener('change', function() {
                    updateOptionDependencies();
                    updateSummary();
                });
            });

            document.querySelectorAll('#customize-form select.option-select-detail').forEach(function(select) {
                select.addEventListener('change', function() {
                    updateSingleSelectDetailPreview(select);
                    updateOptionDependencies();
                    updateSummary();
                });

                updateSingleSelectDetailPreview(select);
            });

            document.querySelectorAll('#customize-form select:not(.option-select-detail)').forEach(function(
                select) {
                select.addEventListener('change', function() {
                    updateOptionDependencies();
                    updateSummary();
                });
            });

            if (quantityInput) {
                quantityInput.addEventListener('input', updateSummary);
                quantityInput.addEventListener('change', updateSummary);
            }

            updateOptionDependencies();
            applyRequiredRules();
            updateVisibleGroupNumbers();
            updateSummary();
        });
    </script>

    {{-- <script>
        document.querySelectorAll('.variant-dropdown-btn').forEach(function(button) {
            button.addEventListener('click', function(event) {
                event.preventDefault();
                event.stopPropagation();

                if (!window.bootstrap || !bootstrap.Dropdown) {
                    return;
                }

                bootstrap.Dropdown.getOrCreateInstance(button).toggle();
            });
        });

        document.querySelectorAll('.variant-dropdown-item').forEach(function(item) {
            item.addEventListener('click', function(event) {
                event.preventDefault();
                event.stopPropagation();

                const card = this.closest('.option-variant-card');

                const variantId = this.dataset.variantId;
                const variantName = this.dataset.variantName || '';
                const colorCode = this.dataset.colorCode || '#ffffff';
                const imageUrl = this.dataset.image || '';
                const variantPrice = this.dataset.price || 0;

                const img = card.querySelector('.variant-main-image');
                const radio = card.querySelector('input[type="radio"]');
                const hiddenInput = card.querySelector('.selected-variant-input');
                const label = card.querySelector('.variant-dropdown-label');
                const btnDot = card.querySelector('.variant-dropdown-btn .variant-color-dot');

                if (img && imageUrl) {
                    img.src = imageUrl;
                }

                if (hiddenInput) {
                    hiddenInput.value = variantId;
                }

                if (label) {
                    label.textContent = variantName;
                }

                if (btnDot) {
                    btnDot.style.background = colorCode;
                }

                if (radio) {
                    radio.checked = true;
                    radio.dataset.variantName = variantName;
                    radio.dataset.variantPrice = variantPrice;
                    radio.dispatchEvent(new Event('change'));
                }

                updateSummary();

                const dropdownButton = this.closest('.dropdown')?.querySelector('.variant-dropdown-btn');

                if (dropdownButton && window.bootstrap && bootstrap.Dropdown) {
                    bootstrap.Dropdown.getOrCreateInstance(dropdownButton).hide();
                }
            });
        });

        document.querySelectorAll('.option-variant-card').forEach(function(card) {
            const radio = card.querySelector('input[type="radio"]');
            const activeItem = card.querySelector('.variant-dropdown-item');
            const label = card.querySelector('.variant-dropdown-label');
            const hiddenInput = card.querySelector('.selected-variant-input');

            if (radio && activeItem) {
                radio.dataset.variantName = activeItem.dataset.variantName || '';
                radio.dataset.variantPrice = activeItem.dataset.price || 0;

                if (label) {
                    label.textContent = activeItem.dataset.variantName || '';
                }

                if (hiddenInput) {
                    hiddenInput.value = activeItem.dataset.variantId || '';
                }
            }
        });

        updateSummary();
    </script> --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.js-variant-select').forEach(function(select) {
                function applyVariant() {
                    const card = select.closest('.option-variant-card');
                    const selected = select.options[select.selectedIndex];

                    if (!card || !selected) {
                        return;
                    }

                    const radio = card.querySelector('input[type="radio"]');
                    const img = card.querySelector('.variant-main-image');

                    const variantName = selected.dataset.variantName || '';
                    const variantPrice = selected.dataset.price || 0;
                    const imageUrl = selected.dataset.image || '';

                    if (img && imageUrl) {
                        img.src = imageUrl;
                    }

                    if (radio) {
                        radio.checked = true;
                        radio.dataset.variantName = variantName;
                        radio.dataset.variantPrice = variantPrice;
                        radio.dispatchEvent(new Event('change'));
                    }

                    if (typeof updateSummary === 'function') {
                        updateSummary();
                    }
                }

                select.addEventListener('change', function(e) {
                    e.stopPropagation();
                    applyVariant();
                });

                applyVariant();
            });

            document.querySelectorAll('.option-variant-card').forEach(function(card) {
                card.addEventListener('click', function(e) {
                    if (e.target.closest('.js-variant-select')) {
                        return;
                    }

                    const radio = card.querySelector('input[type="radio"]');

                    if (radio) {
                        radio.checked = true;
                        radio.dispatchEvent(new Event('change'));
                    }
                });
            });
        });
    </script>

    <script>
        document.querySelectorAll('.add-color-btn').forEach(function(button) {
            button.addEventListener('click', function() {
                const groupId = this.dataset.groupId;
                const box = document.getElementById('custom-color-box-' + groupId);

                if (!box) {
                    return;
                }

                const colorRadios = document.querySelectorAll(
                    '#customize-form input[type="radio"][name="options[' + groupId + ']"]'
                );

                colorRadios.forEach(function(radio) {
                    radio.checked = false;
                });

                box.style.display = 'block';
                this.classList.add('is-active');

                const input = box.querySelector('.custom-color-input');

                if (input) {
                    const groupEl = this.closest('.customize-option-group');
                    const isRequired = groupEl && groupEl.dataset.required === '1';

                    input.required = isRequired;
                    input.focus();
                }

                updateSummary();
            });
        });

        document.querySelectorAll('.option-color-item input[type="radio"]').forEach(function(radio) {
            radio.addEventListener('change', function() {
                const groupId = this.name.match(/\[(.*?)\]/)?.[1];

                if (!groupId) {
                    return;
                }

                const box = document.getElementById('custom-color-box-' + groupId);
                const addButton = document.querySelector('.add-color-btn[data-group-id="' + groupId + '"]');

                if (box) {
                    box.style.display = 'none';

                    const input = box.querySelector('.custom-color-input');

                    if (input) {
                        input.value = '';
                        input.required = false;
                    }
                }

                if (addButton) {
                    addButton.classList.remove('is-active');
                }

                updateSummary();
            });
        });

        document.querySelectorAll('.custom-color-add-btn').forEach(function(button) {
            button.addEventListener('click', function() {
                const box = this.closest('.custom-color-box');
                const input = box.querySelector('.custom-color-input');

                if (!input || !input.value.trim()) {
                    alert('Please specify Pantone color.');
                    return;
                }

                updateSummary();
            });
        });

        document.querySelectorAll('.custom-color-input').forEach(function(input) {
            input.addEventListener('input', updateSummary);
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]');

            popoverTriggerList.forEach(function(popoverTriggerEl) {
                new bootstrap.Popover(popoverTriggerEl, {
                    container: 'body',
                    html: false
                });
            });

            document.addEventListener('click', function(e) {
                popoverTriggerList.forEach(function(popoverTriggerEl) {
                    const popover = bootstrap.Popover.getInstance(popoverTriggerEl);

                    if (
                        popover &&
                        !popoverTriggerEl.contains(e.target) &&
                        !document.querySelector('.popover')?.contains(e.target)
                    ) {
                        popover.hide();
                    }
                });
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const customizeForm = document.getElementById('customize-form');

            if (!customizeForm) {
                return;
            }

            customizeForm.addEventListener('submit', function(e) {
                applyRequiredRules();

                const isValid = validateRequiredOptions();

                if (!isValid) {
                    e.preventDefault();
                    e.stopPropagation();
                    alert('Please select all required options.');
                    return false;
                }
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            function togglePreviousOrderBox(groupId) {
                const radios = document.querySelectorAll(
                    'input.previous-order-radio[name="options[' + groupId + ']"]'
                );

                const box = document.querySelector(
                    '[data-previous-order-box="' + groupId + '"]'
                );

                if (!box) {
                    return;
                }

                const input = box.querySelector('.previous-order-input');

                let selectedIsYes = false;

                radios.forEach(function(radio) {
                    if (radio.checked && radio.dataset.isYes === '1') {
                        selectedIsYes = true;
                    }
                });

                if (selectedIsYes) {
                    box.classList.add('is-open');

                    if (input) {
                        input.required = true;
                    }
                } else {
                    box.classList.remove('is-open');

                    if (input) {
                        input.required = false;
                        input.value = '';
                    }
                }
            }

            document.querySelectorAll('.previous-order-radio').forEach(function(radio) {
                const groupId = radio.name.match(/\[(.*?)\]/)?.[1];

                if (groupId) {
                    togglePreviousOrderBox(groupId);
                }

                radio.addEventListener('change', function() {
                    const groupId = this.name.match(/\[(.*?)\]/)?.[1];

                    if (groupId) {
                        togglePreviousOrderBox(groupId);
                    }

                    updateSummary();
                });
            });

            // เพิ่มตรงนี้
            document.querySelectorAll('.previous-order-input').forEach(function(input) {
                input.addEventListener('input', function() {
                    updateSummary();
                });
            });
        });
        document.querySelectorAll('.option-variant-card').forEach(function(card) {
            card.addEventListener('click', function(e) {
                if (e.target.closest('.variant-dropdown')) {
                    return;
                }

                const radio = card.querySelector('input[type="radio"]');

                if (radio) {
                    radio.checked = true;
                    radio.dispatchEvent(new Event('change'));
                }
            });
        });
    </script>
    <script>
document.addEventListener('DOMContentLoaded', function () {
    const overlay = document.getElementById('stepFocusOverlay');
    const closeBtn = document.getElementById('stepFocusClose');
    const bottomBar = document.getElementById('stepBottomBar');
    const prevBtn = document.getElementById('stepPrevBtn');
    const nextBtn = document.getElementById('stepNextBtn');

    let activeGroupId = null;

    function getVisibleGroups() {
        return Array.from(document.querySelectorAll('.customize-option-group'))
            .filter(group => group.style.display !== 'none');
    }

    function getActiveGroup() {
        if (!activeGroupId) return null;
        return document.querySelector('.customize-option-group[data-group-id="' + activeGroupId + '"]');
    }

    function openStepMode() {
        document.body.classList.add('step-focus-open');
        bottomBar.classList.add('is-open');
    }

    function closeStepMode() {
        activeGroupId = null;

        document.querySelectorAll('.customize-option-group.is-step-active').forEach(function (el) {
            el.classList.remove('is-step-active');
        });

        document.body.appendChild(closeBtn);

        document.body.classList.remove('step-focus-open');
        bottomBar.classList.remove('is-open');
    }

    function updateStepButtons() {
        const groups = getVisibleGroups();
        const activeGroup = getActiveGroup();

        if (!activeGroup) {
            prevBtn.disabled = true;
            nextBtn.disabled = true;
            return;
        }

        const currentIndex = groups.findIndex(group => group === activeGroup);

        prevBtn.disabled = currentIndex <= 0;

        if (currentIndex === groups.length - 1) {
            nextBtn.innerHTML = 'IR PARA QUANTIDADE →';
        } else {
            nextBtn.innerHTML = 'PRÓXIMO PASSO →';
        }

        nextBtn.disabled = false;
    }

    function setActiveGroup(groupEl, shouldScroll = true) {
        if (!groupEl) return;

        document.querySelectorAll('.customize-option-group.is-step-active').forEach(function (el) {
            el.classList.remove('is-step-active');
        });

        groupEl.classList.add('is-step-active');
        groupEl.appendChild(closeBtn);
        activeGroupId = groupEl.dataset.groupId;

        openStepMode();
        updateStepButtons();

        if (shouldScroll) {
            groupEl.scrollIntoView({
                behavior: 'smooth',
                block: 'center'
            });
        }
    }

    function goToNextGroup() {
        const groups = getVisibleGroups();
        const activeGroup = getActiveGroup();

        if (!activeGroup) {
            if (groups.length) {
                setActiveGroup(groups[0]);
            }
            return;
        }

        const currentIndex = groups.findIndex(group => group === activeGroup);
        const nextGroup = groups[currentIndex + 1];

        if (nextGroup) {
            setActiveGroup(nextGroup);
            return;
        }

        const quantitySection = document.querySelector('.quantity-add-cart-section');

        if (quantitySection) {
            closeStepMode();
            quantitySection.scrollIntoView({
                behavior: 'smooth',
                block: 'center'
            });
        }
    }

    function goToPrevGroup() {
        const groups = getVisibleGroups();
        const activeGroup = getActiveGroup();

        if (!activeGroup) return;

        const currentIndex = groups.findIndex(group => group === activeGroup);
        const prevGroup = groups[currentIndex - 1];

        if (prevGroup) {
            setActiveGroup(prevGroup);
        }
    }

    function refreshStepModeAfterDependencyChange() {
        const activeGroup = getActiveGroup();

        if (!activeGroup) return;

        if (activeGroup.style.display === 'none') {
            const visibleGroups = getVisibleGroups();

            if (visibleGroups.length) {
                setActiveGroup(visibleGroups[0], false);
            } else {
                closeStepMode();
            }
        } else {
            updateStepButtons();
        }
    }

    // คลิกที่ group ไหน ให้ group นั้นเด้งเป็น focus
    document.querySelectorAll('.customize-option-group').forEach(function (groupEl) {
        groupEl.addEventListener('click', function (e) {
            if (e.target.closest('.info-popover-btn, .step-focus-close')) {
                return;
            }

            setActiveGroup(groupEl, false);
        });
    });

    // ถ้ามีการเลือก option / focus input ให้ถือว่า group นั้น active
    document.querySelectorAll('#customize-form .js-option-input, .custom-color-input, .previous-order-input').forEach(function (input) {
        input.addEventListener('change', function () {
            const groupEl = this.closest('.customize-option-group');
            if (groupEl) {
                setActiveGroup(groupEl, false);
            }
        });

        input.addEventListener('focus', function () {
            const groupEl = this.closest('.customize-option-group');
            if (groupEl) {
                setActiveGroup(groupEl, false);
            }
        });
    });

    prevBtn.addEventListener('click', function () {
        goToPrevGroup();
    });

    nextBtn.addEventListener('click', function () {
        goToNextGroup();
    });

    overlay.addEventListener('click', function () {
        closeStepMode();
    });

    closeBtn.addEventListener('click', function (e) {
        e.preventDefault();
        e.stopPropagation();
        closeStepMode();
    });

    // เปิดให้ function อื่นเรียกได้
    window.refreshStepModeAfterDependencyChange = refreshStepModeAfterDependencyChange;
});
</script>
@endsection
