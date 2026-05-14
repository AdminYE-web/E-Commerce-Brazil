@extends('layouts.app')

@section('title', ucfirst($type) . ' Address Information')

@section('css')
<style>
    .account-page {
        background: #f3f3f3;
        padding: 32px 0;
        min-height: 620px;
    }

    .account-layout {
        display: grid;
        grid-template-columns: 280px 1fr;
        gap: 36px;
        align-items: start;
    }

    .address-card {
        background: #fff;
        border-radius: 8px;
        padding: 42px 54px;
        min-height: 420px;
    }

    .address-card h1 {
        font-size: 34px;
        font-weight: 700;
        margin-bottom: 18px;
    }

    .address-divider {
        border-top: 1px solid #e5e5e5;
        margin-bottom: 24px;
        max-width: 560px;
    }

    .address-form {
        max-width: 780px;
    }

    .address-form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    .address-group {
        margin-bottom: 20px;
    }

    .address-group.full {
        grid-column: 1 / -1;
    }

    .address-group label {
        display: block;
        margin-bottom: 8px;
        font-size: 14px;
        color: #111;
    }

    .address-group label span {
        color: #ff0000;
    }

    .address-group input,
    .address-group select {
        width: 100%;
        height: 38px;
        border: 1px solid #cfd4dc;
        border-radius: 4px;
        padding: 0 14px;
        font-size: 14px;
        background: #fff;
    }

    .address-3-col {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr;
        gap: 14px;
    }

    .address-checkbox {
        display: flex;
        gap: 8px;
        align-items: flex-start;
        margin: 14px 0 20px;
        font-size: 14px;
    }

    .address-checkbox input {
        margin-top: 3px;
    }

    .address-actions-row {
        display: flex;
        align-items: center;
        gap: 34px;
    }

    .save-btn {
        min-width: 106px;
        height: 29px;
        border: 0;
        border-radius: 4px;
        background: #2f70c9;
        color: #fff;
        font-weight: 700;
    }

    .cancel-link {
        color: #111;
        text-decoration: none;
        font-weight: 700;
    }

    .error-text {
        color: #dc2626;
        font-size: 12px;
        margin-top: 5px;
    }

    @media (max-width: 900px) {
        .account-layout {
            grid-template-columns: 1fr;
        }

        .address-card {
            padding: 28px 22px;
        }

        .address-form-grid,
        .address-3-col {
            grid-template-columns: 1fr;
        }
    }
    .zip-code-row {
    display: flex;
    gap: 10px;
}

.zip-code-row input {
    flex: 1;
}

.search-address-btn {
    height: 38px;
    padding: 0 18px;
    border: 0;
    border-radius: 4px;
    background: #000;
    color: #fff;
    font-weight: 600;
    white-space: nowrap;
}
</style>
@endsection

@section('content')
<div class="account-page">
    <div class="container">
        <div class="account-layout">

            @include('account.partials.sidebar', ['user' => $user])

            <main class="address-card">
                <h1>{{ ucfirst($type) }} Address Information</h1>
                <div class="address-divider"></div>

                <form action="{{ route('account.addresses.store', $type) }}" method="POST" class="address-form">
                    @csrf

                    <div class="address-group full">
                        <label>Label <span>*</span></label>
                        <input type="text" name="label" value="{{ old('label') }}" placeholder="Label">
                        @error('label') <div class="error-text">{{ $message }}</div> @enderror
                    </div>

                    <div class="address-form-grid">
                        <div class="address-group">
                            <label>First Name<span>*</span></label>
                            <input type="text" name="first_name" value="{{ old('first_name') }}" placeholder="First Name">
                            @error('first_name') <div class="error-text">{{ $message }}</div> @enderror
                        </div>

                        <div class="address-group">
                            <label>Last Name<span>*</span></label>
                            <input type="text" name="last_name" value="{{ old('last_name') }}" placeholder="Last Name">
                            @error('last_name') <div class="error-text">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="address-group full">
                        <label>Phone<span>*</span></label>
                        <input type="text" name="phone" value="{{ old('phone') }}" placeholder="Phone number">
                        @error('phone') <div class="error-text">{{ $message }}</div> @enderror
                    </div>

                    <div class="address-group full">
                        <label>Company Name (optional)</label>
                        <input type="text" name="company_name" value="{{ old('company_name') }}" placeholder="Company Name">
                        @error('company_name') <div class="error-text">{{ $message }}</div> @enderror
                    </div>

                    <div class="address-group full">
                        <label>Address<span>*</span></label>
                        <input type="text" name="address" value="{{ old('address') }}" placeholder="Street address">
                        @error('address') <div class="error-text">{{ $message }}</div> @enderror
                    </div>

                    <div class="address-group full">
                        <label>Apartment, suite, etc. (optional)</label>
                        <input type="text" name="apartment" value="{{ old('apartment') }}" placeholder="Apartment, suite, unit, etc.">
                        @error('apartment') <div class="error-text">{{ $message }}</div> @enderror
                    </div>

                    <div class="address-group full">
                        <label>Country<span>*</span></label>
                        <select name="country">
                            <option value="">Select country</option>
                            <option value="Japan" {{ old('country') === 'Japan' ? 'selected' : '' }}>Japan</option>
                            <option value="Thailand" {{ old('country') === 'Thailand' ? 'selected' : '' }}>Thailand</option>
                        </select>
                        @error('country') <div class="error-text">{{ $message }}</div> @enderror
                    </div>

                    <div class="address-3-col">
                        <div class="address-group">
                            <label>City<span>*</span></label>
                            <input
    type="text"
    name="city"
    id="city"
    value="{{ old('city') }}"
    placeholder="City"
>
                            @error('city') <div class="error-text">{{ $message }}</div> @enderror
                        </div>

                        <div class="address-group">
                            <label>State<span>*</span></label>
                            <select name="state" id="state">
                                <option value="">Select state</option>
                                @foreach(['Tokyo','Osaka','Kyoto','Hokkaido','Fukuoka','Aichi','Kanagawa','Saitama','Chiba'] as $state)
                                    <option value="{{ $state }}" {{ old('state') === $state ? 'selected' : '' }}>
                                        {{ $state }}
                                    </option>
                                @endforeach
                            </select>
                            @error('state') <div class="error-text">{{ $message }}</div> @enderror
                        </div>

                        <div class="address-group">
    <label>Zip code<span>*</span></label>

    <div class="zip-code-row">
        <input
            type="text"
            name="zip_code"
            id="zip_code"
            class="postcode-input"
            value="{{ old('zip_code') }}"
            placeholder="ZIP code"
        >

        <button type="button" class="search-address-btn" id="searchAddressBtn">
            Check
        </button>
    </div>

    @error('zip_code')
        <div class="error-text">{{ $message }}</div>
    @enderror
</div>
                    </div>

                    <label class="address-checkbox">
                        <input type="checkbox" name="is_main" value="1" {{ old('is_main') ? 'checked' : '' }}>
                        <span>Set as main {{ $type }} address.</span>
                    </label>

                    <div class="address-actions-row">
                        <button type="submit" class="save-btn">
                            Save
                        </button>

                        <a href="{{ route('account.addresses.index', $type) }}" class="cancel-link">
                            Cancel
                        </a>
                    </div>
                </form>
            </main>

        </div>
    </div>
</div>
@endsection
@section('js')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const zipInput = document.getElementById('zip_code');
    const searchBtn = document.getElementById('searchAddressBtn');
    const cityInput = document.getElementById('city');
    const stateSelect = document.getElementById('state');

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

    async function fillAddressByZipCode() {
        if (!zipInput) {
            return;
        }

        const postcode = cleanPostcode(zipInput.value);

        if (!postcode) {
            alert('Please enter zip code.');
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

            setSelectValue(stateSelect, mainArea);

            if (cityInput) {
                cityInput.value = subArea;
            }

        } catch (error) {
            console.error(error);
            alert('Cannot load address. Please try again.');
        }
    }

    if (searchBtn) {
        searchBtn.addEventListener('click', fillAddressByZipCode);
    }

    if (zipInput) {
        zipInput.addEventListener('input', function () {
            this.value = this.value.replace(/[^\d]/g, '');
        });

        zipInput.addEventListener('paste', function () {
            setTimeout(() => {
                this.value = this.value.replace(/[^\d]/g, '');
            }, 0);
        });
    }
});
</script>
@endsection