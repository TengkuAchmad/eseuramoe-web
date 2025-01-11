$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
});
const App = {
    loadingShow(attr=null) {
        if (attr == null) {
            $('body').prepend(`<div class="loading-overlay"><div class="custom-loader"></div></div>`);
        }else{
            $(attr).prepend(`<div class="loading-overlay" style="position:absolute"><div class="custom-loader"></div></div>`);
        }
    },
    loadingHide(attr=null) {
        if (attr == null) {
            $('body').find('.loading-overlay').remove();
        }else{
            $(attr).find('.loading-overlay').remove();
        }
    },
    formResetError(attrform) {
        let __form = $('#' + attrform)
        __form.find('.is-invalid').removeClass('is-invalid')
        __form.find('.is-valid').removeClass('is-valid')
        __form.find('.invalid-feedback').remove()
        __form.find('.valid-feedback').remove()
        __form.find('.select2 .select2-selection').removeClass('border border-danger')
    },
    formSubmit(attrform, url,prefixAttribute, successCallback,errorCallback, customFormData) {
        const _this = this
        return $(document).on('submit', '#' + attrform, function (e) {
            e.preventDefault();
            swal.fire({
                title: 'Confirmation',
                text: "Are you sure want to submit?",
                showCancelButton: true,
                confirmButtonText: 'Yes',
                cancelButtonText: 'No',
            }).then(function (result) {
                if (result.value) {
                    App.formResetError(attrform)
                    let __form = $('#' + attrform)
                    App.loadingShow();
                    let formData = new FormData(document.getElementById(attrform));
                    if (typeof customFormData == "function") {
                        const checkForm = customFormData(formData);
                        if (checkForm instanceof FormData) {
                            formData = checkForm
                        }
                    }
                    if (url == undefined) {
                        url = $('#' + attrform).attr('action')
                        console.log(url);
                    }
                    $.ajax({
                        url: url,
                        type: 'post',
                        processData: false,
                        contentType: false,
                        data: formData,
                        dataType: 'json',
                        success: function (response) {
                            App.loadingHide();
                            if (successCallback !== undefined) {
                                successCallback(response)
                            }
                        },
                        error: function (response) {
                            App.loadingHide();
                            toastr.clear();
                            if (errorCallback !== undefined) {
                                errorCallback(response)
                            }
                            if (response.status >= 500) {
                                toastr.error('Something when wrong, please try again later!', 'Error');
                            } else {
                                let prefix = '';
                                if (typeof prefixAttribute !== 'undefined' && typeof prefixAttribute === "string") {
                                    prefix = prefixAttribute
                                }
                                $.each(response.responseJSON.errors, (key, val) => {
                                    key = key.replaceAll(".", "-");
                                    var el = __form.find(`#${prefix}${key}`);
                                    console.log(key);
                                    el.parent().find('.select2 .select2-selection').addClass('border border-danger')
                                    let valid = val.length > 0 ? 'invalid' : 'valid'
                                    if (el.closest('.custom-control.custom-checkbox').length) {
                                        // el.closest('.custom-control.custom-checkbox').addClass('is-'+valid)
                                        el.closest('input[type="checkbox"]').addClass('is-' + valid)
                                    }

                                    el.addClass('is-' + valid)
                                    // if(el.parent().find('.input-group-append').length){
                                    //     el.parent().find('.input-group-append').append('<div class="invalid-feedback">'+val+'</div>');
                                    // }
                                    // else{
                                    val = String(val).replaceAll("_", " ").replace(/\.[\d]/g, ' ')
                                    if (el.closest('.input-group').length) {
                                        el.closest('.input-group').append('<div class="' + valid + '-feedback">' + val + '</div>');
                                    }
                                    else if (el.parent().find('.select2').length) {
                                        el.parent().find('.select2').after('<div class="' + valid + '-feedback">' + val + '</div>')
                                    }
                                    else if (el.closest('.dropdown').length) {
                                        el.closest('.dropdown').addClass('is-invalid').append('<div class="' + valid + '-feedback">' + val + '</div>');
                                    } else {
                                        el.after('<div class="' + valid + '-feedback">' + val + '</div>');
                                    }

                                    // }
                                });
                                if (undefined !== response.responseJSON.message) {
                                    toastr.error(response.responseJSON.message, 'Error');
                                } else {
                                    toastr.error("The data you entered is not valid yet , please recheck the data!", 'Error');
                                }

                            }


                        }
                    });
                }
                return false;
            }).catch(swal.noop);
        });
    },
    delete: function (url, callback) {
        Swal.fire({
            title: "Do you want to delete this data?",
            showDenyButton: true,
            showConfirmButton: true,
            // showCancelButton: true,
            confirmButtonText: `Yes`,
            denyButtonText: `No`,
            backdrop: true,
            showLoaderOnConfirm: true,
            allowEscapeKey: () => !Swal.isLoading(),
            allowEnterKey: () => !Swal.isLoading(),
            allowOutsideClick: () => !Swal.isLoading(),
            preConfirm: function () {
                return new Promise(function (resolve) {
                    $.ajax({
                        type: "DELETE",
                        url: url,
                        dataType: "json",
                    })
                        .done((response) => {
                            if (typeof callback !== 'undefined') {
                                callback?.ajax?.reload(null, false);
                            }
                            toastr.clear();
                            toastr.success('The data has been deleted!', 'Success');
                        })
                        .fail((response) => {
                            toastr.clear();
                            if (undefined !== response.responseJSON.message) {
                                toastr.error(response.responseJSON.message, 'Error');
                            } else {
                                toastr.error('Something when wrong, please try again!', 'Error');
                            }
                        })
                        .always(() => resolve());
                });
            },
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                // Swal.fire("Saved!", "", "success");
                // console.log(result);
                // if (callback instanceof Function) {
                //     callback;
                // }
            }
        });
    }
}
