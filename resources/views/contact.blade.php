@extends('layouts.app')

@section('title', 'Contato')

@section('css')
    <style>
        /* ── Contact form validation states ── */
        .contact-field-error {
            transition: opacity 0.25s ease;
        }

        .contact-field.is-invalid input,
        .contact-field.is-invalid select,
        .contact-field.is-invalid textarea {
            box-shadow: 0 0 0 2px rgba(200, 40, 29, 0.35);
            background: #fff5f5;
        }

        .contact-field.is-invalid input:focus,
        .contact-field.is-invalid select:focus,
        .contact-field.is-invalid textarea:focus {
            box-shadow: 0 0 0 2px rgba(200, 40, 29, 0.5);
            background: #fff5f5;
        }

        .contact-field.is-valid input,
        .contact-field.is-valid select,
        .contact-field.is-valid textarea {
            box-shadow: 0 0 0 2px rgba(20, 108, 46, 0.25);
        }

        .contact-fieldset.is-invalid .contact-radio-group {
            padding: 6px 10px;
            border-radius: 6px;
            box-shadow: 0 0 0 2px rgba(200, 40, 29, 0.35);
            background: #fff5f5;
        }

        .contact-fieldset.is-valid .contact-radio-group {
            padding: 6px 10px;
            border-radius: 6px;
            box-shadow: 0 0 0 2px rgba(20, 108, 46, 0.25);
        }

    </style>
@endsection

@section('content')
    <section class="contact-hero" aria-labelledby="contact-page-title">
        <div class="contact-hero__inner">
            <h1 id="contact-page-title">Contato</h1>
            <p>Tem alguma d&uacute;vida ou precisa de suporte?</p>
        </div>
    </section>

    <section class="contact-page">
        <div class="contact-hex contact-hex--left" aria-hidden="true">
            <span class="contact-hex__cell contact-hex__cell--1"></span>
            <span class="contact-hex__cell contact-hex__cell--2"></span>
            <span class="contact-hex__cell contact-hex__cell--3"></span>
            <span class="contact-hex__cell contact-hex__cell--4"></span>
            <span class="contact-hex__cell contact-hex__cell--5"></span>
            <span class="contact-hex__cell contact-hex__cell--6"></span>
            <span class="contact-hex__cell contact-hex__cell--7"></span>
            <span class="contact-hex__cell contact-hex__cell--8"></span>
            <span class="contact-hex__cell contact-hex__cell--9"></span>
        </div>
        <div class="contact-hex contact-hex--right" aria-hidden="true">
            <span class="contact-hex__cell contact-hex__cell--1"></span>
            <span class="contact-hex__cell contact-hex__cell--2"></span>
            <span class="contact-hex__cell contact-hex__cell--3"></span>
            <span class="contact-hex__cell contact-hex__cell--4"></span>
            <span class="contact-hex__cell contact-hex__cell--5"></span>
            <span class="contact-hex__cell contact-hex__cell--6"></span>
            <span class="contact-hex__cell contact-hex__cell--7"></span>
            <span class="contact-hex__cell contact-hex__cell--8"></span>
            <span class="contact-hex__cell contact-hex__cell--9"></span>
        </div>

        <div class="contact-shell">
            <div class="contact-intro">
                <div class="contact-logo-placeholder" aria-hidden="true"></div>

                <div class="contact-intro__copy">
                    <h2>Fale conosco</h2>
                    <p>Deixe seus dados no formul&aacute;rio abaixo e retornaremos em breve.</p>
                </div>
            </div>

            <form class="contact-form-card" id="contactForm" action="{{ route('contact.submit') }}" method="POST" enctype="multipart/form-data" novalidate>
                @csrf

                <div class="contact-alert contact-alert--success" data-contact-success hidden></div>
                <div class="contact-alert contact-alert--error" data-contact-error hidden></div>

                <fieldset class="contact-fieldset">
                    <legend><span>*</span>Como gostaria de ser contactado?</legend>

                    <div class="contact-radio-group">
                        <label class="contact-radio">
                            <input type="radio" name="contact_method" value="whatsapp" @checked(old('contact_method', 'whatsapp') === 'whatsapp')>
                            <span>WhatsApp</span>
                        </label>

                        <label class="contact-radio">
                            <input type="radio" name="contact_method" value="line" @checked(old('contact_method') === 'line')>
                            <span>LINE</span>
                        </label>

                        <label class="contact-radio">
                            <input type="radio" name="contact_method" value="phone" @checked(old('contact_method') === 'phone')>
                            <span>Liga&ccedil;&atilde;o</span>
                        </label>
                    </div>
                    <div class="contact-field-error" data-error-for="contact_method">@error('contact_method'){{ $message }}@enderror</div>
                </fieldset>

                <div class="contact-field">
                    <label for="contact-subject"><span>*</span>Assunto</label>
                    <select id="contact-subject" name="subject" required>
                        <option value="payment" @selected(old('subject') === 'payment')>Pagamento</option>
                        <option value="quote" @selected(old('subject') === 'quote')>Solicita&ccedil;&atilde;o de or&ccedil;amento</option>
                        <option value="support" @selected(old('subject') === 'support')>Suporte</option>
                        <option value="order" @selected(old('subject') === 'order')>Pedido existente</option>
                    </select>
                    <div class="contact-field-error" data-error-for="subject">@error('subject'){{ $message }}@enderror</div>
                </div>

                <div class="contact-field">
                    <label for="contact-name"><span>*</span>Nome</label>
                    <input id="contact-name" type="text" name="name" placeholder="Seu nome" value="{{ old('name') }}" required>
                    <div class="contact-field-error" data-error-for="name">@error('name'){{ $message }}@enderror</div>
                </div>

                <div class="contact-field">
                    <label for="contact-email"><span>*</span>Email</label>
                    <input id="contact-email" type="email" name="email" placeholder="Digite seu melhor e-mail" value="{{ old('email') }}" required>
                    <div class="contact-field-error" data-error-for="email">@error('email'){{ $message }}@enderror</div>
                </div>

                <div class="contact-field">
                    <label for="contact-line">LINE-ID</label>
                    <input id="contact-line" type="text" name="line_id" placeholder="Seu ID do LINE" value="{{ old('line_id') }}">
                    <div class="contact-field-error" data-error-for="line_id">@error('line_id'){{ $message }}@enderror</div>
                </div>

                <div class="contact-field">
                    <label for="contact-phone">Telefone</label>
                    <div class="contact-phone-row">
                        <select aria-label="Country code" name="country_code">
                            <option value="+81" @selected(old('country_code', '+81') === '+81')>(JP)+81</option>
                            <option value="+55" @selected(old('country_code') === '+55')>(BR)+55</option>
                            <option value="+1" @selected(old('country_code') === '+1')>(US)+1</option>
                        </select>

                        <input id="contact-phone" type="tel" name="phone" placeholder="00000-0000" value="{{ old('phone') }}">
                    </div>
                    <div class="contact-field-error" data-error-for="phone">@error('phone'){{ $message }}@enderror</div>
                </div>

                <div class="contact-field">
                    <label for="contact-message"><span>*</span>Mensagem</label>
                    <textarea id="contact-message" name="message" placeholder="Ol&aacute;, quero fazer meu pedido!" required>{{ old('message') }}</textarea>
                    <div class="contact-field-error" data-error-for="message">@error('message'){{ $message }}@enderror</div>
                </div>

                <div class="contact-field contact-field--file">
                    <label for="contact-file">File Upload</label>
                    <input id="contact-file" type="file" name="attachment">
                    <div class="contact-field-error" data-error-for="attachment">@error('attachment'){{ $message }}@enderror</div>
                </div>

                <div class="contact-recaptcha-wrap">
                    <div class="contact-recaptcha">
                        @if (config('services.recaptcha.site_key'))
                            <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.site_key') }}" data-callback="onRecaptchaSuccess" data-expired-callback="onRecaptchaExpired"></div>
                        @else
                            <div class="contact-recaptcha-unavailable">reCAPTCHA is not configured.</div>
                        @endif
                    </div>
                    <div class="contact-field-error" data-error-for="g-recaptcha-response">@error('g-recaptcha-response'){{ $message }}@enderror</div>
                </div>

                <button class="contact-submit" type="submit" disabled>
                    <span>Enviar solicita&ccedil;&atilde;o de or&ccedil;amento</span>
                    <i class="bi bi-arrow-right" aria-hidden="true"></i>
                </button>
            </form>

            <div class="contact-info-grid" aria-label="Informa&ccedil;&otilde;es de contato">
                <article class="contact-info-card">
                    <div class="contact-info-card__icon">
                        <i class="bi bi-envelope"></i>
                    </div>
                    <h3>E-mail</h3>
                    <p>sales@xxxxx-xxxxxx.com</p>
                </article>

                <article class="contact-info-card">
                    <div class="contact-info-card__icon">
                        <i class="bi bi-geo-alt"></i>
                    </div>
                    <h3>Endere&ccedil;o</h3>
                    <p>1234 Maple Street Xixox 210</p>
                    <p>San Francisco, CA 94107</p>
                    <p>Japan(Seg-Sex: 10:00-16:00)</p>
                </article>

                <article class="contact-info-card">
                    <div class="contact-info-card__icon">
                        <i class="bi bi-telephone"></i>
                    </div>
                    <h3>Telefone</h3>
                    <p>+81 5068655592</p>
                </article>
            </div>
        </div>
    </section>
@endsection

@section('js')
    <script>
        /* ── reCAPTCHA callback (must be global, before api.js loads) ── */
        function onRecaptchaSuccess() {
            var btn = document.querySelector('.contact-submit');
            if (btn) btn.disabled = false;
        }
        function onRecaptchaExpired() {
            var btn = document.querySelector('.contact-submit');
            if (btn) btn.disabled = true;
        }
    </script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
        crossorigin="anonymous"></script>
    <script>
        $(function() {
            const $form = $('#contactForm');
            const $submit = $form.find('.contact-submit');
            const $successAlert = $('[data-contact-success]');
            const $errorAlert = $('[data-contact-error]');
            const defaultSubmitHtml = $submit.html();

            /* ── Validation rules ── */
            const EMAIL_RE = /^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/;
            const PHONE_RE = /^[\d\s\-().+]{7,20}$/;
            const ALLOWED_FILE_TYPES = [
                'image/jpeg', 'image/png', 'image/gif', 'image/webp',
                'application/pdf',
                'application/msword',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
            ];
            const MAX_FILE_SIZE = 5 * 1024 * 1024; // 5 MB

            /**
             * Returns an error message string or null if valid.
             */
            function validateField(fieldName) {
                const contactMethod = $form.find('[name="contact_method"]:checked').val();

                switch (fieldName) {
                    case 'contact_method':
                        return contactMethod ? null : 'Selecione um método de contato.';

                    case 'name': {
                        const v = $form.find('[name="name"]').val().trim();
                        if (!v) return 'O campo nome é obrigatório.';
                        if (v.length < 2) return 'O nome deve ter pelo menos 2 caracteres.';
                        if (v.length > 100) return 'O nome não pode ter mais de 100 caracteres.';
                        return null;
                    }

                    case 'email': {
                        const v = $form.find('[name="email"]').val().trim();
                        if (!v) return 'O campo e-mail é obrigatório.';
                        if (!EMAIL_RE.test(v)) return 'Informe um e-mail válido.';
                        return null;
                    }

                    case 'line_id': {
                        const v = $form.find('[name="line_id"]').val().trim();
                        if (contactMethod === 'line' && !v) return 'O LINE-ID é obrigatório quando o método de contato é LINE.';
                        return null;
                    }

                    case 'phone': {
                        const v = $form.find('[name="phone"]').val().trim();
                        if ((contactMethod === 'phone' || contactMethod === 'whatsapp') && !v) {
                            return 'O telefone é obrigatório para o método de contato selecionado.';
                        }
                        if (v && !PHONE_RE.test(v)) return 'Informe um número de telefone válido.';
                        return null;
                    }

                    case 'message': {
                        const v = $form.find('[name="message"]').val().trim();
                        if (!v) return 'O campo mensagem é obrigatório.';
                        if (v.length < 10) return 'A mensagem deve ter pelo menos 10 caracteres.';
                        return null;
                    }

                    case 'attachment': {
                        const input = $form.find('[name="attachment"]')[0];
                        if (input.files.length === 0) return null; // optional
                        const file = input.files[0];
                        if (file.size > MAX_FILE_SIZE) return 'O arquivo não pode exceder 5 MB.';
                        if (ALLOWED_FILE_TYPES.length && !ALLOWED_FILE_TYPES.includes(file.type)) {
                            return 'Tipo de arquivo não permitido. Use JPG, PNG, GIF, WEBP, PDF ou DOC.';
                        }
                        return null;
                    }

                    default:
                        return null;
                }
            }

            /**
             * Apply or clear visual state for a single field.
             * Returns true when the field is valid.
             */
            function applyFieldState(fieldName, errorMsg) {
                const $errorDiv = $form.find('[data-error-for="' + fieldName + '"]');
                let $wrapper;

                if (fieldName === 'contact_method') {
                    $wrapper = $form.find('.contact-fieldset').first();
                } else {
                    $wrapper = $errorDiv.closest('.contact-field');
                    if (!$wrapper.length) $wrapper = $errorDiv.closest('.contact-recaptcha-wrap');
                }

                if (errorMsg) {
                    $errorDiv.text(errorMsg);
                    $wrapper.removeClass('is-valid').addClass('is-invalid');
                    return false;
                } else {
                    $errorDiv.text('');
                    // Only show valid state if the field has been interacted with
                    const hasValue = fieldName === 'contact_method'
                        ? $form.find('[name="contact_method"]:checked').length > 0
                        : !!$form.find('[name="' + fieldName + '"]').val();
                    $wrapper.removeClass('is-invalid');
                    if (hasValue) $wrapper.addClass('is-valid');
                    else $wrapper.removeClass('is-valid');
                    return true;
                }
            }

            /**
             * Validate a single field and update UI.
             */
            function validateAndShow(fieldName) {
                const error = validateField(fieldName);
                return applyFieldState(fieldName, error);
            }

            /**
             * Validate all fields. Returns true if form is valid.
             */
            const ALL_FIELDS = ['contact_method', 'name', 'email', 'line_id', 'phone', 'message', 'attachment'];

            function validateAll() {
                let allValid = true;
                let $firstInvalid = null;

                ALL_FIELDS.forEach(function(field) {
                    const valid = validateAndShow(field);
                    if (!valid && !$firstInvalid) {
                        const $el = $form.find('[data-error-for="' + field + '"]');
                        $firstInvalid = $el.closest('.contact-field, .contact-fieldset, .contact-recaptcha-wrap');
                    }
                    if (!valid) allValid = false;
                });

                // Scroll to first error
                if ($firstInvalid && $firstInvalid.length) {
                    $('html, body').animate({
                        scrollTop: $firstInvalid.offset().top - 120
                    }, 350);
                }

                return allValid;
            }

            /* ── Clear helpers ── */
            function clearContactMessages() {
                $successAlert.prop('hidden', true).text('');
                $errorAlert.prop('hidden', true).text('');
                $form.find('.contact-field-error').text('');
                $form.find('.contact-field, .contact-fieldset').removeClass('is-invalid is-valid');
            }

            function setSubmitting(isSubmitting) {
                $submit.prop('disabled', isSubmitting);
                $submit.html(isSubmitting ? '<span>Enviando...</span>' : defaultSubmitHtml);
            }

            function resetRecaptcha() {
                if (typeof grecaptcha !== 'undefined') {
                    grecaptcha.reset();
                }
                // Re-disable submit button after reset
                $submit.prop('disabled', true);
            }

            function showServerValidationErrors(errors) {
                $.each(errors, function(field, messages) {
                    const message = Array.isArray(messages) ? messages[0] : messages;
                    applyFieldState(field, message);
                });
            }

            /* ── Real-time validation on blur ── */
            $form.find('[name="name"], [name="email"], [name="line_id"], [name="phone"], [name="message"]')
                .on('blur', function() {
                    const name = $(this).attr('name');
                    validateAndShow(name);
                })
                .on('input', function() {
                    // Clear error while typing (if previously invalid)
                    const $wrapper = $(this).closest('.contact-field');
                    if ($wrapper.hasClass('is-invalid')) {
                        validateAndShow($(this).attr('name'));
                    }
                });

            // Radio buttons – validate on change
            $form.find('[name="contact_method"]').on('change', function() {
                validateAndShow('contact_method');
                // Re-validate conditional fields when method changes
                validateAndShow('line_id');
                validateAndShow('phone');
            });

            // File input – validate on change
            $form.find('[name="attachment"]').on('change', function() {
                validateAndShow('attachment');
            });

            /* ── Submit handler ── */
            $form.on('submit', function(event) {
                event.preventDefault();

                // Clear previous messages
                $successAlert.prop('hidden', true).text('');
                $errorAlert.prop('hidden', true).text('');


                // Frontend validation gate
                if (!validateAll()) {
                    $errorAlert.text('Por favor, corrija os campos destacados e tente novamente.')
                        .prop('hidden', false);
                    return;
                }

                setSubmitting(true);

                $.ajax({
                    url: $form.attr('action'),
                    method: 'POST',
                    data: new FormData($form[0]),
                    processData: false,
                    contentType: false,
                    headers: {
                        'Accept': 'application/json'
                    },
                    success: function(response) {
                        if (response.redirect) {
                            window.location.href = response.redirect;
                            return;
                        }
                        $successAlert.text(response.message || 'Sua solicitação de contato foi enviada com sucesso.')
                            .prop('hidden', false);
                        $form[0].reset();
                        clearContactMessages();
                        resetRecaptcha();
                    },
                    error: function(xhr) {
                        resetRecaptcha();

                        if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                            showServerValidationErrors(xhr.responseJSON.errors);
                            $errorAlert.text('Por favor, corrija os campos destacados e tente novamente.')
                                .prop('hidden', false);
                            return;
                        }

                        $errorAlert.text('Não foi possível enviar sua solicitação no momento. Tente novamente mais tarde.')
                            .prop('hidden', false);
                    },
                    complete: function() {
                        setSubmitting(false);
                    }
                });
            });
        });
    </script>
@endsection
