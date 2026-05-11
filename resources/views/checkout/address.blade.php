@extends('layouts.app')

@section('title', 'Checkout Address')

@section('css')
    <style>
        .checkout-page {
            background: #f5f6f8;
            padding: 30px 0 60px;
        }

        .checkout-stepper {
            max-width: 760px;
            margin: 0 auto 34px;
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            position: relative;
        }

        .checkout-stepper::before {
            content: "";
            position: absolute;
            top: 25px;
            left: 70px;
            right: 70px;
            height: 3px;
            background: #d9d9d9;
            z-index: 1;
        }

        .checkout-stepper::after {
            content: "";
            position: absolute;
            top: 25px;
            left: 70px;
            width: calc(((100% - 140px) / 4) * 2);
            height: 3px;
            background: #48c26b;
            z-index: 2;
        }

        .checkout-step {
            position: relative;
            z-index: 3;
            width: 120px;
            text-align: center;
        }

        .step-circle {
            width: 52px;
            height: 52px;
            margin: 0 auto 8px;
            border-radius: 50%;
            border: 2px solid #d9d9d9;
            background: #f5f6f8;
            color: #a7b1c2;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            font-weight: 600;
        }

        .step-label {
            font-size: 15px;
            color: #9aa8bd;
            font-weight: 500;
        }

        .checkout-step.completed .step-circle {
            background: #48c26b;
            border-color: #48c26b;
            color: #fff;
            font-size: 30px;
            font-weight: 700;
        }

        .checkout-step.completed .step-label {
            color: #111;
            font-weight: 600;
        }

        .checkout-step.current .step-circle {
            background: #f5f6f8;
            border-color: #2f6fff;
            color: #2f6fff;
        }

        .checkout-step.current .step-label {
            color: #2f6fff;
            font-weight: 600;
        }

        .checkout-layout {
            display: grid;
            grid-template-columns: 1fr 330px;
            gap: 28px;
            align-items: start;
        }

        .checkout-form-card {
            background: #fff;
            border-radius: 12px;
            padding: 28px 34px;
            margin-bottom: 22px;
        }

        .checkout-form-card h3 {
            font-size: 22px;
            font-weight: 800;
            margin-bottom: 18px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px 28px;
        }

        .form-group.full {
            grid-column: 1 / -1;
        }

        .form-group label {
            display: block;
            font-size: 14px;
            margin-bottom: 8px;
            color: #111;
        }

        .required {
            color: #ef4444;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            height: 42px;
            border: 1px solid #cfd4dc;
            border-radius: 5px;
            padding: 0 12px;
            font-size: 14px;
            background: #fff;
        }

        .postcode-row {
            display: flex;
            gap: 10px;
        }

        .postcode-row input {
            max-width: 220px;
        }

        .search-address-btn {
            height: 42px;
            padding: 0 20px;
            border: 0;
            border-radius: 5px;
            background: #000;
            color: #fff;
            font-weight: 600;
        }

        .billing-checkbox {
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 22px 0;
            font-size: 14px;
        }

        .billing-checkbox input {
            width: 18px;
            height: 18px;
        }

        .billing-section {
            display: none;
        }

        .billing-section.is-open {
            display: block;
        }

        .checkout-summary {
            background: #fff;
            border-radius: 12px;
            padding: 22px;
            position: sticky;
            top: 20px;
        }

        .checkout-summary h3 {
            font-size: 22px;
            font-weight: 800;
        }

        .summary-title {
            font-weight: 700;
            margin-bottom: 12px;
        }

        .summary-line,
        .summary-total {
            display: flex;
            justify-content: space-between;
            padding: 9px 0;
            border-bottom: 1px solid #e5e7eb;
        }

        .summary-total {
            border-bottom: 0;
            font-size: 20px;
            font-weight: 800;
            margin-top: 10px;
        }

        .checkout-tip {
            background: #eef5ff;
            color: #2563eb;
            padding: 12px;
            border-radius: 8px;
            font-size: 13px;
            margin: 16px 0;
        }

        .coupon-row {
            display: flex;
            margin-bottom: 16px;
        }

        .coupon-row input {
            flex: 1;
            height: 38px;
            border: 1px solid #d1d5db;
            border-radius: 6px 0 0 6px;
            padding: 0 12px;
        }

        .coupon-row button {
            width: 42px;
            border: 0;
            background: #1d4f91;
            color: #fff;
            border-radius: 0 6px 6px 0;
            font-size: 20px;
        }

        .checkout-next-btn,
        .checkout-back-btn {
            width: 100%;
            height: 42px;
            border-radius: 999px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
        }

        .checkout-next-btn {
            border: 0;
            background: #2563eb;
            color: #fff;
            font-weight: 700;
        }

        .checkout-back-btn {
            margin-top: 10px;
            border: 1px solid #d1d5db;
            color: #111;
            background: #fff;
        }

        .error-text {
            color: #ef4444;
            font-size: 12px;
            margin-top: 4px;
        }

        @media (max-width: 991px) {
            .checkout-layout {
                grid-template-columns: 1fr;
            }

            .checkout-summary {
                position: static;
            }
        }

        @media (max-width: 768px) {
            .form-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endsection

@section('content')


    <form action="{{ route('checkout.storeAddressStep') }}" method="POST">
        @csrf

        <div class="checkout-page">
            <div class="container">

                @include('checkout.partials.stepper', ['currentStep' => 3])

                <div class="checkout-layout">

                    <div class="checkout-left">

                        @if ($errors->any())
                            <div class="checkout-form-card">
                                <div style="color:#ef4444;">
                                    Please check the required fields.
                                </div>
                            </div>
                        @endif

                        <div class="checkout-form-card">
                            <h3>1. Informações Pessoais</h3>

                            <div class="form-grid">
                                <div class="form-group">
                                    <label>Nome (First Name)<span class="required">*</span></label>
                                    <input type="text" name="personal_first_name"
                                        value="{{ old('personal_first_name', $personal['first_name'] ?? '') }}"
                                        placeholder="Ex: Mario">
                                    @error('personal_first_name')
                                        <div class="error-text">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>Sobrenome (Last Name)<span class="required">*</span></label>
                                    <input type="text" name="personal_last_name"
                                        value="{{ old('personal_last_name', $personal['last_name'] ?? '') }}"
                                        placeholder="Ex: Silva Junior">
                                    @error('personal_last_name')
                                        <div class="error-text">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group full">
                                    <label>Phone<span class="required">*</span></label>
                                    <input type="text" name="personal_phone"
                                        value="{{ old('personal_phone', $personal['phone'] ?? '') }}"
                                        placeholder="Ex: 090-XXXX-XXXX">
                                    @error('personal_phone')
                                        <div class="error-text">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group full">
                                    <label>Email<span class="required">*</span></label>
                                    <input type="email" name="personal_email"
                                        value="{{ old('personal_email', $personal['email'] ?? '') }}"
                                        placeholder="Ex: exemplo@email.com">
                                    @error('personal_email')
                                        <div class="error-text">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="checkout-form-card">
                            <h3>2. Endereço de Entrega (Japão)</h3>

                            <div class="form-grid">
                                <div class="form-group full">
                                    <label>Código Postal (CEP)</label>
                                    <div class="postcode-row">
                                        <input type="text" name="shipping_postcode" class="postcode-input"
                                            data-address-type="shipping"
                                            value="{{ old('shipping_postcode', $shippingAddress['postcode'] ?? '') }}"
                                            placeholder="〒135-0064">

                                        <button type="button" class="search-address-btn js-search-address"
                                            data-address-type="shipping">
                                            Buscar Endereço
                                        </button>
                                    </div>
                                    @error('shipping_postcode')
                                        <div class="error-text">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group full">
                                    <label>Província (Estado/Ken)<span class="required">*</span></label>
                                    <select name="shipping_province" id="shipping_province">
                                        <option value="">Selecione uma província...</option>
                                        @foreach (['Tokyo', 'Osaka', 'Kyoto', 'Hokkaido', 'Fukuoka', 'Aichi', 'Kanagawa', 'Saitama', 'Chiba'] as $province)
                                            <option value="{{ $province }}"
                                                {{ old('shipping_province', $shippingAddress['province'] ?? '') == $province ? 'selected' : '' }}>
                                                {{ $province }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('shipping_province')
                                        <div class="error-text">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>Cidade / Distrito (Shi/Ku/Machi)<span class="required">*</span></label>
                                    <input type="text" name="shipping_city" id="shipping_city"
                                        value="{{ old('shipping_city', $shippingAddress['city'] ?? '') }}"
                                        placeholder="Ex: Shinjuku-ku">
                                    @error('shipping_city')
                                        <div class="error-text">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>Bairro / Área (Chome/Ban/Go)<span class="required">*</span></label>
                                    <input type="text" name="shipping_area"
                                        value="{{ old('shipping_area', $shippingAddress['area'] ?? '') }}"
                                        placeholder="Ex: Nishishinjuku 2-8-1">
                                    @error('shipping_area')
                                        <div class="error-text">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group full">
                                    <label>Nome do Prédio / Apartamento e Número do Quarto<span
                                            class="required">*</span></label>
                                    <input type="text" name="shipping_building_room"
                                        value="{{ old('shipping_building_room', $shippingAddress['building_room'] ?? '') }}"
                                        placeholder="Ex: Edifício ABC, Apto 101">
                                    @error('shipping_building_room')
                                        <div class="error-text">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <label class="billing-checkbox">
                            <input type="checkbox" name="billing_same_as_shipping" value="1"
                                id="billing_same_as_shipping"
                                {{ old('billing_same_as_shipping', $billingSame) ? 'checked' : '' }}>
                            Endereço de faturamento é o mesmo que o de entrega.
                        </label>

                        <div class="checkout-form-card billing-section" id="billing-section">
                            <h3>3. Endereço de Faturamento</h3>

                            <div class="form-grid">
                                <div class="form-group">
                                    <label>Nome (First Name)</label>
                                    <input type="text" name="billing_first_name"
                                        value="{{ old('billing_first_name', $billing['first_name'] ?? '') }}"
                                        placeholder="Ex: Mario">
                                </div>

                                <div class="form-group">
                                    <label>Sobrenome (Last Name)</label>
                                    <input type="text" name="billing_last_name"
                                        value="{{ old('billing_last_name', $billing['last_name'] ?? '') }}"
                                        placeholder="Ex: Silva Junior">
                                </div>

                                <div class="form-group full">
                                    <label>Phone</label>
                                    <input type="text" name="billing_phone"
                                        value="{{ old('billing_phone', $billing['phone'] ?? '') }}"
                                        placeholder="Ex: 090-XXXX-XXXX">
                                </div>

                                <div class="form-group full">
                                    <label>Email</label>
                                    <input type="email" name="billing_email"
                                        value="{{ old('billing_email', $billing['email'] ?? '') }}"
                                        placeholder="Ex: exemplo@email.com">
                                </div>

                                <div class="form-group full">
                                    <label>Código Postal (CEP)</label>

                                    <div class="postcode-row">
                                        <input type="text" name="billing_postcode" class="postcode-input"
                                            data-address-type="billing"
                                            value="{{ old('billing_postcode', $billing['postcode'] ?? '') }}"
                                            placeholder="〒135-0064">

                                        <button type="button" class="search-address-btn js-search-address"
                                            data-address-type="billing">
                                            Buscar Endereço
                                        </button>
                                    </div>
                                </div>

                                <div class="form-group full">
                                    <label>Província</label>
                                    <select name="billing_province" id="billing_province">
                                        <option value="">Selecione uma província...</option>
                                        @foreach (['Tokyo', 'Osaka', 'Kyoto', 'Hokkaido', 'Fukuoka', 'Aichi', 'Kanagawa', 'Saitama', 'Chiba'] as $province)
                                            <option value="{{ $province }}"
                                                {{ old('billing_province', $billing['province'] ?? '') == $province ? 'selected' : '' }}>
                                                {{ $province }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Cidade / Distrito</label>
                                    <input type="text" name="billing_city" id="billing_city"
                                        value="{{ old('billing_city', $billing['city'] ?? '') }}">
                                </div>

                                <div class="form-group">
                                    <label>Bairro / Área</label>
                                    <input type="text" name="billing_area"
                                        value="{{ old('billing_area', $billing['area'] ?? '') }}">
                                </div>

                                <div class="form-group full">
                                    <label>Nome do Prédio / Apartamento e Número do Quarto</label>
                                    <input type="text" name="billing_building_room"
                                        value="{{ old('billing_building_room', $billing['building_room'] ?? '') }}">
                                </div>
                            </div>
                        </div>

                    </div>

                    @include('checkout.partials.summary-sidebar', [
                        'backRoute' => route('checkout.index'),
                        'backText' => 'Voltar ao Upload de Arte',
                        'nextText' => 'Próximo Passo: Pagamento →',
                    ])

                </div>
            </div>
        </div>
    </form>
@endsection

@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const checkbox = document.getElementById('billing_same_as_shipping');
            const billingSection = document.getElementById('billing-section');

            function toggleBillingSection() {
                if (checkbox.checked) {
                    billingSection.classList.remove('is-open');
                } else {
                    billingSection.classList.add('is-open');
                }
            }

            checkbox.addEventListener('change', toggleBillingSection);
            toggleBillingSection();
        });


        document.addEventListener('DOMContentLoaded', function() {
            const checkbox = document.getElementById('billing_same_as_shipping');
            const billingSection = document.getElementById('billing-section');

            function toggleBillingSection() {
                if (!checkbox || !billingSection) {
                    return;
                }

                if (checkbox.checked) {
                    billingSection.classList.remove('is-open');
                } else {
                    billingSection.classList.add('is-open');
                }
            }

            if (checkbox) {
                checkbox.addEventListener('change', toggleBillingSection);
                toggleBillingSection();
            }

            function cleanPostcode(value) {
                return (value || '').replace(/[^\d]/g, '');
            }

            function setSelectValue(select, value) {
                if (!select || !value) {
                    return;
                }

                const normalizedValue = String(value).trim();

                let matched = false;

                Array.from(select.options).forEach(function(option) {
                    if (option.value === normalizedValue || option.text.trim() === normalizedValue) {
                        option.selected = true;
                        matched = true;
                    }
                });

                if (!matched) {
                    const newOption = new Option(normalizedValue, normalizedValue, true, true);
                    select.add(newOption);
                }

                select.dispatchEvent(new Event('change'));
            }

            async function fillAddressByPostcode(type) {
                const postcodeInput = document.querySelector(`input[name="${type}_postcode"]`);
                const provinceSelect = document.querySelector(`select[name="${type}_province"]`);
                const cityInput = document.querySelector(`input[name="${type}_city"]`);

                if (!postcodeInput) {
                    return;
                }

                const postcode = cleanPostcode(postcodeInput.value);

                if (!postcode) {
                    alert('Please enter postcode.');
                    return;
                }

                try {
                    const response = await LoadGeoCode(postcode);

                    console.log('LoadGeoCode response:', response);

                    if (!response) {
                        alert('Address not found.');
                        return;
                    }

                    const mainArea = response.mainArea || '';
                    const subArea = response.subArea || '';

                    setSelectValue(provinceSelect, mainArea);

                    if (cityInput) {
                        cityInput.value = subArea;
                    }

                } catch (error) {
                    console.error(error);
                    alert('Cannot load address. Please try again.');
                }
            }

            document.querySelectorAll('.js-search-address').forEach(function(button) {
                button.addEventListener('click', function() {
                    const type = this.dataset.addressType;
                    fillAddressByPostcode(type);
                });
            });
            document.querySelectorAll('.postcode-input').forEach(function(input) {
                input.addEventListener('input', function() {
                    this.value = this.value.replace(/[^\d]/g, '');
                });

                input.addEventListener('paste', function() {
                    setTimeout(() => {
                        this.value = this.value.replace(/[^\d]/g, '');
                    }, 0);
                });
            });
        });
    </script>

@endsection
