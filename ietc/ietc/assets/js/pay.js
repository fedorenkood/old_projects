var Payment = new $.Class({
    initialize: function(parameters) {
        if (parameters && typeof(parameters) !== 'object') {
            throw "Sorry, 'params' argument of Payment should be a JSON object containing parameter values"
        }
        for (var parameter in parameters) {
            if (typeof(this[parameter]) === 'undefined') throw "Sorry, 'parameters{" + parameter + "} passed to Payment is not recognized"
        }
        for (parameter in parameters) {
            this[parameter] = parameters[parameter]
        }
        this.form = $(this.id);
        this.initAccount();
        this.initAuthPanel();
        this.initValidators();
        this.initListeners();
        this.initMasks()
    }
});
Payment.extend({
    id: '#payment-form',
    amountId: '#bill_amount',
    phoneId: '#phone',
    account: null,
    auth: null,
    receipt: null,
    _isRadioOver: false,
    _signed: false,
    initValidators: function() {
        if (!$.validator) {
            return false
        }
        this._addPhoneValidator();
        this._addRegExValidator();
        this._addEmailValidator();
        this._addCreditCardValidators();
        var self = this;
        $.validator.prototype.elements = function() {
            var validator = this,
                rulesCache = {};
            return $(this.currentForm).find("input, select, textarea").not(":submit, :reset, :image, [disabled], [readonly]:not(.ui-cvv2-field)").not(this.settings.ignore).filter(':visible').filter(function() {
                if (this.name in rulesCache || !validator.objectLength($(this).rules())) {
                    return false
                }
                rulesCache[this.name] = true;
                return true
            })
        };
        this.form.validate({
            errorElement: 'span',
            errorClass: 'help-block',
            onkeyup: false,
            ignore: '.ignore, .temp-ignore, [type="hidden"]',
            onsubmit: false,
            showErrors: function(errorMap, errorList) {
                if (self._isRadioOver) {
                    return
                }
                this.defaultShowErrors()
            },
            highlight: function(element) {
                $(element).closest('.form-group').addClass('has-error');
                $(element).closest('.input-group').addClass('has-error');
                $(element).closest('.validation-group').addClass('has-error')
            },
            unhighlight: function(element) {
                $(element).closest('.form-group').removeClass('has-error');
                $(element).closest('.input-group').removeClass('has-error');
                $(element).closest('.validation-group').removeClass('has-error')
            },
            errorPlacement: function(error, element) {
                if (error.text() !== '') {
                    if (element.hasClass('validthru')) {
                        error.insertAfter(element.parent())
                    } else if (element.parent('.input-group').length && !element.parents('.form-inline').length) {
                        error.insertAfter(element.parent())
                    } else {
                        element.parent().append(error)
                    }
                }
            }
        });
        return true
    },
    initListeners: function() {
        var self = this;
        this.form.find('.form-control').focus(function() {
            $(this).parent('.payment-input-group').addClass('focused')
        }).focusout(function() {
            $(this).parent('.payment-input-group').removeClass('focused')
        });
        this.form.find('.control-label').mouseover(function() {
            self._isRadioOver = true
        }).mouseleave(function() {
            self._isRadioOver = false
        });
        $(':radio[name="payment_method"]').change(function() {
            self.form.find('.radio-group.has-error').removeClass('has-error').find('.help-block').hide();
            var parent = $(this).parents('.form-group');
            $('.payment-input-group').addClass('disable-inputs');
            $('.payment-input-group input').prop('disabled', true);
            $('input, textarea, select', '.payment-input-group').addClass('temp-ignore').attr('formnovalidate', '');
            $('.payment-input-group', parent).removeClass('disable-inputs');
            $('.payment-input-group input', parent).prop('disabled', false);
            $('.payment-input-group .temp-ignore', parent).removeClass('temp-ignore').removeAttr('formnovalidate').find('.help-block').show();
            $('#' + $(this).val()).focus()
        });
        $(':radio[name="payment_method"]:checked').trigger('change');
        $(document).on('click', 'span.logout', function() {
            self.auth.logout()
        });
        $(document).on('click', 'button#newOperationButton', function(e) {
            e.preventDefault();
            $('#tForm').hide();
            $('#completeForm').remove();
            $('.page-header').show();
            $('.well').show();
            self.form.removeClass('hide');
            self.receipt = null
        });
        $(document).on('click', 'button#getReceipt', function(e) {
            e.preventDefault();
            var email = $.trim($('#emailClient').val());
            if (email) {
                $('#emailButton').removeClass('disabled').prop('disabled', false)
            }
            var mailForm = $('.send-mail-form-portmone');
            if (mailForm.is(':visible')) {
                mailForm.hide()
            } else {
                mailForm.show()
            }
        });
        $(document).on('input', '#emailClient', function(e) {
            if ($(this).data('lastval') !== $(this).val()) {
                $(this).data('lastval', $(this).val());
                var email = $.trim($('#emailClient').val()),
                    submitButton = $('#emailButton');
                if (email) {
                    if (self._isValidEmail(email)) {
                        submitButton.removeClass('disabled').prop('disabled', false)
                    } else {
                        submitButton.addClass('disabled').prop('disabled', true)
                    }
                } else {
                    submitButton.addClass('disabled').prop('disabled', true)
                }
            }
        });
        $(document).on('click', 'button#emailButton', function(e) {
            e.preventDefault();
            self._sendReceipt()
        });
        $(document).on('click', 'button#linkingSignup', function(e) {
            e.preventDefault();
            self._signUp($(this).attr('token'))
        })
    },
    initAccount: function() {
        var self = this,
            curLocale = CONFIG.lang || 'ru';
        Account.prototype.messages[curLocale] = $.extend(Account.prototype.messages[curLocale], CONFIG.messages);
        this.account = new Account({
            curLocale: curLocale,
            remote: CONFIG.isUser || false,
            isAsync: true,
            bootstrapLoaded: true,
            amountEl: this.amountId,
            noButtons: true,
            beforeSubmit: function(form) {
                $('#card_number').val(this._unmaskedVal($('#card_number_mask').val(), 'space'));
                return self.onBeforeSubmit(form)
            },
            onInitComplete: function() {
                return self.onInitComplete()
            },
            onError: function(errors) {
                return self.onError(errors)
            },
            onSuccess: function(response) {
                return self.onSuccess(response)
            },
            onComplete: function(data) {
                return self.onComplete(data)
            },
            _checkErrors: function() {
                var valid = self.form.valid();
                if (!valid) {
                    self.form.data('validator').focusInvalid()
                }
                return valid
            },
            _showErrors: function(error) {
                if ('string' === $.type(error)) {
                    sweetAlert({
                        type: 'error',
                        title: CONFIG.messages.error,
                        text: error,
                        confirmButtonClass: 'btn-danger'
                    })
                }
            }
        })
    },
    initAuthPanel: function() {
        this.auth = new AuthPanel({
            account: this.account,
            _updateAccount: function() {
                this.hide();
                this.account.remote = true;
                this.account._setUserAccounts()
            }
        })
    },
    initMasks: function() {
        $(this.phoneId).mask('380 (99) 999-99-99', {
            placeholder: "380 (__) ___-__-__",
            translation: {
                0: {
                    pattern: /[0]/,
                    fallback: '0'
                },
                '9': {
                    pattern: /\d/
                }
            }
        });
        $(this.amountId).numberField({
            ints: 6,
            floats: 2
        })
    },
    onInitComplete: function() {
        var hint = $('.cvv2 .hint');
        if (!hint.length) {
            return false
        }
        $('.cvv2 label').on('mouseover, mousemove', function(event) {
            hint.addClass('visible').offset({
                left: event.pageX - 205,
                top: event.pageY + 15
            }).css({
                zIndex: 999,
                position: 'absolute'
            })
        }).on('mouseout', function(event) {
            hint.removeClass('visible')
        });
        return true
    },
    onBeforeSubmit: function(form) {
        return true
    },
    onError: function(errors) {
        this.account._showErrors(errors.error)
    },
    onSuccess: function(response) {
        $('.page-header').hide();
        $('.well').hide();
        $('#tForm').show();
        var tmpl = $('#completeTemplate').tmpl(response);
        tmpl.appendTo('#tForm');
        if (response) {
            this.receipt = response.sb
        }
        $('#account-cvv2').val('');
        $('#cards-success').next('#pdf-links').remove();
        $('#cards-success').remove();
        return true
    },
    onComplete: function(data) {
        return true
    },
    _addPhoneValidator: function() {
        $.validator.addMethod('mobile', function(value, element, param) {
            var val = value.replace(/[\s\(\)\-]+/g, '');
            return this.optional(element) || param && val.length === 12
        }, $.validator.messages.required)
    },
    _addRegExValidator: function() {
        $.validator.addMethod('regex', function(value, element, regexp) {
            var re = new RegExp(regexp);
            return this.optional(element) || re.test(value)
        }, $.validator.messages.required)
    },
    _addEmailValidator: function() {
        var self = this;
        $.validator.addMethod('email', function(value, element) {
            var val = $.trim(value);
            if (val.length) {
                return self._isValidEmail(value)
            }
            return true
        })
    },
    _addCreditCardValidators: function() {
        var self = this,
            now = new Date(),
            curMonth = now.getMonth() + 1,
            curYear = now.getFullYear() - 2000;
        $.validator.addMethod('creditcard', function(value, element) {
            return self._isValidCreditCard(value)
        }, CONFIG.messages.cardNumberError);
        $.validator.addMethod('validthru', function(value, element) {
            var container = $(element).closest('.expirationDate'),
                elements = $(container).find('.validthru');
            if (elements.length) {
                var month = parseInt(elements[0].value),
                    year = parseInt(elements[1].value);
                if (year === curYear && month < curMonth) {
                    return false
                }
            }
            return true
        }, CONFIG.messages.cardExpirationError);
        $.validator.addMethod('cvv2', function(value, element) {
            return value.length === 3
        }, CONFIG.messages.cardCVV2Empty)
    },
    _isValidEmail: function(email) {
        var pattern = new RegExp(/^((\"[\w-\s]+\")|([\w-]+(?:\.[\w-]+)*)|(\"[\w-\s]+\")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
        return pattern.test(email)
    },
    _isValidCreditCard: function(card) {
        if (/[^0-9 ]+/.test(card)) {
            return false
        }
        card = card.replace(/\D/g, "");
        if (card.length !== 16) {
            return false
        }
        var nCheck = 0,
            nDigit = 0,
            bEven = false,
            n, cDigit;
        for (n = card.length - 1; n >= 0; n--) {
            cDigit = card.charAt(n);
            nDigit = parseInt(cDigit, 10);
            if (bEven) {
                if ((nDigit *= 2) > 9) {
                    nDigit -= 9
                }
            }
            nCheck += nDigit;
            bEven = !bEven
        }
        return (nCheck % 10) === 0
    },
    _sendReceipt: function() {
        var dataObj = this.receipt || {};
        dataObj.format = 'json';
        dataObj.email = $('#emailClient').val();
        dataObj.lang = CONFIG.lang;
        $.ajax({
            type: 'POST',
            url: CONFIG.baseUrl + 'terminal/index/email-by-hash',
            data: dataObj,
            async: true,
            dataType: 'json',
            beforeSend: function() {
                $().preloader('show');
                $('#emailButton').prop('disabled', true);
                $('#emailClient').prop('disabled', true)
            },
            success: function(data) {
                if (data.response.success == 'true') {
                    $('.send-mail-form-portmone').css({
                        'display': 'none'
                    });
                    $('#emailButton').prop('disabled', false);
                    $('#emailClient').prop('disabled', false);
                    sweetAlert({
                        type: 'success',
                        title: CONFIG.messages.success,
                        text: CONFIG.messages.receiptMailSuccess,
                        confirmButtonClass: 'btn-success'
                    })
                } else {
                    $('.send-mail-form-portmone').css({
                        'display': 'none'
                    });
                    $('#emailButton').prop('disabled', false);
                    $('#emailClient').prop('disabled', false);
                    sweetAlert({
                        type: 'error',
                        title: CONFIG.messages.error,
                        text: CONFIG.messages.receiptMailError,
                        confirmButtonClass: 'btn-danger'
                    })
                }
            },
            error: function() {
                sweetAlert({
                    type: 'error',
                    title: CONFIG.messages.error,
                    text: CONFIG.messages.receiptMailError,
                    confirmButtonClass: 'btn-danger'
                })
            },
            complete: function() {
                $().preloader('hide')
            }
        })
    },
    _signUp: function(token) {
        this.auth.show()
    }
});