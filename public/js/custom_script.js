/* Document is not ready */
    /**
     * ----------------------------------------------------------------
     * Ajax Setup for CSRF
     * ----------------------------------------------------------------
     */
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content'),
        }
    })

    /**
     * ----------------------------------------------------------------
     * Reset Form
     * ----------------------------------------------------------------
     */
    function resetForm() {
        $('#form')[0].reset();
        let inputs       = $('#form').find('input:not([type=hidden], [role=switch]), select, textarea');
        let input_switch = $('#form').find('input[role=switch]');
        if (input_switch.length > 0) {
            $(input_switch).attr('checked', true);
        }
        inputs.each((key, input) => {
            let error_element = $(input).siblings('small.text-danger');
            if (error_element) {
                $(input).removeClass('is-invalid');
                // remove element
                error_element.remove();
            }
        })
    }

    /**
     * ----------------------------------------------------------------
     * Show Loading and disabling inputs for processing
     * ----------------------------------------------------------------
     */
    function processForm(form_id, loading = true) {
        let button      = $(`button[form=${form_id}]`);
        let button_text = button.text();
        $(`#${form_id}`).find('fieldset').prop('disabled', loading);
        button.prop('disabled', loading).html(`${loading ? '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>' : ''} ${button_text}`);
    }

    /**
     * ----------------------------------------------------------------
     * Submit Form
     * ----------------------------------------------------------------
     */
    $(document).on('submit', '#form', function(event) {
        event.preventDefault();
        let url    = $(this).attr('action');
        let method = $(this).attr('method');
        let data   = $(this).serialize();
        let modal  = $(this).closest('.modal');
        $.ajax({
            method,
            url,
            data,
            beforeSend: processForm($(this).attr('id')),
            success: (res) => {
                processForm($(this).attr('id'), false);
                if (res) {
                    Swal.fire({
                        title: res.status ? res.title : 'Failed',
                        text: res.message,
                        icon: res.status ? 'success' : 'failed',
                        focusConfirm: false,
                        confirmButtonText: 'Confirm',
                        didRender: () => {
                            $(document).on('keydown', async function(e) {
                                if (e.key === 'Enter') {
                                    await Swal.getConfirmButton().click();
                                    $(document).off('keydown');
                                }
                            })
                        }
                    }).then((result) => {
                        // Close the Bootstrap modal
                        modal.modal('hide');
                        // Clear form inputs
                        resetForm();
                        // Refresh DataTables data
                        $('#table').DataTable().ajax.reload();
                    });
                }
            },
            error: (err) => {
                if (err.status === 400) {
                    processForm($(this).attr('id'), false);
                    if (!$('.modal-body').find('p.alert').length) {
                        $('.modal-body').append(`<p class="alert alert-danger text-center mb-0">${err.responseJSON.message}</p>`);
                    }
                } else {
                    processForm($(this).attr('id'), false);
                    let errors = err.responseJSON.errors;
                    $.each(errors, (key, error) => {
                        // add red border effect
                        $(this).find(`#${key}`).addClass('is-invalid');
                        // add error message
                        let target = $(this).find(`#${key}`).closest('div');
                        if (target.find('small.text-danger').length < 1) {
                            target.append(`<small class="text-danger">${error}</small>`);
                        }
                    });
                }
            }
        })

    })

/* Document is ready */
$(function() {
    /**
     * ----------------------------------------------------------------
     * Remove error texts when input is clicked/focused
     * ----------------------------------------------------------------
     */
    $(document).on('shown.bs.modal', '#modal', function() {
        $('input, select').on('focus', function() {
            let error_element = $(this).siblings('small.text-danger');
            if (error_element) {
                $(this).removeClass('is-invalid');
                // remove element
                error_element.remove();
            }
            let error_alert   = $(this).closest('.modal-body').find('p.alert');
            if (error_alert) {
                error_alert.remove();
            }
        })
    });

    /**
     * ----------------------------------------------------------------
     * Reset form on modal hide
     * ----------------------------------------------------------------
     */
    $(document).on('hidden.bs.modal', '#modal', function() {
        resetForm();
    });

    /**
     * ----------------------------------------------------------------
     * Populating the form
     * ----------------------------------------------------------------
     */
    $(document).on('click', '#modal_btn', async function() {
        let id = $(this).data('id')
        // change the label depends if edit or add modal
        $('#modal_label').text(id ? 'Edit Modal' : 'Add Modal');
        $('#form').attr('action', id ? `${window.location.href}/${id}` : `${window.location.href}`);
        $('#form').attr('method', id ? 'PUT' : 'POST');
        // if button has id means it is for edit
        if (id) {
            await $.ajax({
                method: 'GET',
                url: `${window.location.href}/${id}/edit`, // get the data from ajax call
                success: (res) => {
                    $.each(res, (key, val) => {
                        if (key === 'status') {
                            $('#form').find(`#${key}`).attr('checked', !!val);
                        } else {
                            $(`#${key}`).val(val);
                        }
                    })
                }
            });
        } else {
            resetForm();
        }
        $('#modal').modal('show');
    });

    /**
     * ----------------------------------------------------------------
     * Fetch options everytime it focuses
     * ----------------------------------------------------------------
     */
    let selected_value;
    $(document).on('focus', 'select', function(event) {
        let url = $(this).data('list');
        $.ajax({
            url,
            method: 'GET',
            success: (res) => {
                let first_option = $(this).children().get(0);
                selected_value   = $(this).find('option:selected').attr('value');
                $(this).html(first_option); // rewrite the select tag, with the first option
                $.each(res, (index, value) => {
                    $(this).append(`<option value="${value.id}">${value.data_list_name}</option>`);
                })
                if (selected_value) {
                    $(this).find(`option[value=${selected_value}]`).prop('selected', true);
                }
            }
        })
    })
});
