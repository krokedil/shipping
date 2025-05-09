jQuery(function ($) {
  ksEditOrder = {
    /**
     * The parameters from the localization.
     *
     * @type {object}
     */
    params: ks_edit_order_params,

    /**
     * Register event listeners.
     *
     * @return {void}
     */
    init: function () {
      $(document.body).on("click", ".ks-metabox__edit-pp", (event) => {
        event.preventDefault();
        this.toggleEditShippingInfo(event);
      });

      $(document.body).on("click", ".ks-metabox__change-pp-button", (event) => {
        this.changePickupPoint(event);
      });
    },

    /**
     * Return the wrapper select for the shipping line id.
     *
     * @param {string} shippingLineId
     *
     * @return {jQuery}
     */
    getWrapper: function (shippingLineId) {
      return $(`.ks-metabox__wrapper[data-shipping-line-id=${shippingLineId}]`);
    },

    /**
     * Return the select element for the shipping line id.
     *
     * @param {string} shippingLineId
     *
     * @return {jQuery}
     */
    getSelect: function (shippingLineId) {
      return $(`#ks-metabox__selected-pp-${shippingLineId}`);
    },

    /**
     * Return the selected pickup point for the shipping line id.
     *
     * @param {string} shippingLineId
     *
     * @return {string}
     */
    getSelectedPickupPoint: function (shippingLineId) {
      return $(
        `#ks-metabox__selected-pp-${shippingLineId} option:selected`
      ).val();
    },

    /**
     * Return the edit button for the shipping line id.
     *
     * @param {string} shippingLineId
     *
     * @return {jQuery}
     */
    getEditButton: function (shippingLineId) {
      return $(
        `.ks-metabox__edit-pp[data-shipping-line-id="${shippingLineId}"]`
      );
    },

    /**
     * Return the change form for the shipping line id.
     *
     * @param {string} shippingLineId
     *
     * @return {jQuery}
     */
    getChangeForm: function (shippingLineId) {
      return $(
        `.ks-metabox__change-pp[data-shipping-line-id="${shippingLineId}"]`
      );
    },

    /**
     * Return the change button for the shipping line id.
     *
     * @param {string} shippingLineId
     *
     * @return {jQuery}
     */
    getChangeButton: function (shippingLineId) {
      return $(
        `.ks-metabox__change-pp-button[data-shipping-line-id="${shippingLineId}"]`
      );
    },

    /**
     * Toggle the display of the edit shipping information form.
     *
     * @param {} event
     */
    toggleEditShippingInfo: function (event) {
      // Get the shipping line id from the data tag of the target element.
      const shippingLineId = $(event.target).data("shipping-line-id");

      // Toggle the display of the edit shipping information form.
      ksEditOrder.getChangeForm(shippingLineId).toggle();
    },

    /**
     * Change the selected pickup point for the shipping line.
     *
     * @param {Event} event
     */
    changePickupPoint: function (event) {
      const { action, nonce, url } =
        ksEditOrder.params.ajax.updateSelectedPickupPoint;

      // Get the shipping line id from the data tag of the target element.
      const shippingLineId = $(event.target).data("shipping-line-id");
      const wrapper = ksEditOrder.getWrapper(shippingLineId);
      // Block the UI to prevent multiple clicks.
      wrapper.block({
        message: null,
        overlayCSS: {
          background: "#fff",
          opacity: 0.6,
        },
      });

      // Clear any existing messages.
      wrapper.find(`.ks-metabox__message`).remove();

      // Get the selected pickup point from the select element.
      const pickupPointId = ksEditOrder.getSelectedPickupPoint(shippingLineId);

      // Make a ajax request to the server to update the pickup point.
      $.ajax({
        type: "POST",
        url: url,
        data: {
          action: action,
          nonce: nonce,
          shippingLineId: shippingLineId,
          pickupPointId: pickupPointId,
          orderId: $("#post_ID").val(), // Get the order id from the hidden input from WooCommerce.
        },
        success: (response) => {
          // Test if the response is a success or not.
          if (!response.success) {
            // Prepend a success message to the wrapper.
            addMessage(wrapper, response.data.message, "error");
            return;
          }
          // Update the shipping line.
          ksEditOrder.updateShippingLine(shippingLineId, response.data);
          ksEditOrder.addMessage(wrapper, response.data.message);

          // Unblock the UI.
          wrapper.unblock();
        },
        error: (response) => {
          console.error("Failed to change the pickup point", response);
          addMessage(wrapper, "Failed to change the pickup point.", "error");
          // Unblock the UI.
          wrapper.unblock();
        },
      });
    },

    /**
     * Update the shipping line.
     *
     * @param {string} shippingLineId
     * @param {object} data
     */
    updateShippingLine: function (shippingLineId, data) {
      // Get the fragments from the response.
      const fragments = data.fragments;
      const wrapper = ksEditOrder.getWrapper(shippingLineId);
      // For each fragment, update the DOM inside the wrapper for the shipping line.
      for (const fragment in fragments) {
        wrapper.find(fragment).html(fragments[fragment]);
      }
    },

    /**
     * Add a message to a shipping line.
     *
     * @param {jQuery} wrapper
     * @param {string} message
     * @param {string} type
     *
     * @return {void}
     */
    addMessage: function (wrapper, message, type = "success") {
      const messageClass = type === "success" ? "success" : "error";
      // Clear any existing messages.
      wrapper.find(`.ks-metabox__message`).remove();

      // Add the message to the change form.
      wrapper
        .find(".ks-metabox__change-pp")
        .prepend(
          `<div class="ks-metabox__message ks-metabox__message-${messageClass}">${message}</div>`
        );
    },
  };

  ksEditOrder.init();
});
