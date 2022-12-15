// form ajax submit helper
export function initFormAjax(selector, ajaxConfig = {}) {
  $(document).on("submit", selector, function (e) {
    const showValidation = $(selector).attr("show-validation") !== undefined;
    if (showValidation) {
      $(document).on("change", ".input-error", function (e) {
        const errorMsgEl = ($(e.target).parent().find('~ small.text-error').length) ? $(e.target).parent().find('~ small.text-error') : $(e.target).find('~ small.text-error')
        errorMsgEl.remove();
        $(e.target).removeClass("input-error");
      });
    }


    var data = new FormData(document.querySelector(selector))


    const defaultConfig = {
      url: $(selector).attr("action"),
      type: "POST",
      cache: false,
      contentType: false,
      processData: false,
      data: data,
      beforeSend: function () {
        $(".invalid-msg").remove();
      },
      error: function (xhr) {
        const response = xhr.responseJSON;
        const errors = response.errors || response.messages
        if (showValidation && (errors)) {
          for (const err in errors) {
            const keyError = err.replace("[]", "")
            const $parent = $(`#${keyError}, [data-error=${keyError}]`).parent();
            $(`[name=${keyError}], [data-error=${keyError}]`).addClass("input-error");
            if ($parent.find("small.text-error").length == 0) {
              $parent.append(
                `<small class="text-error invalid-msg">${errors[err]}</small>`
              );
            }
          }
        }

        if (response.messages.error) toastr.error(response.messages.error, "Perhatian");

      },
      success: function (data) {
        toastr.success(data.message, "sukses", {
          timeOut: 5000
        });

        if (data.formReset) {
          $(selector).trigger("reset");
        }
      },
    };

    const mergedConfig = {
      ...defaultConfig,
      ...ajaxConfig
    };

    e.preventDefault();
    $.ajax(mergedConfig);
  });
}