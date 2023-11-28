jQuery(function ($) {
  const krokedilPickupPointSelect = {
    /**
     * The select element for the pickup point selection.
     *
     * @type {string}
     */
    selectSelector: "#krokedil_shipping_pickup_point",

    /**
     * The parameters from the localization.
     *
     * @type {object}
     */
    params: ks_pp_params,

    /**
     * Register event listeners.
     *
     * @return {void}
     */
    init: function () {
      this.initSelectWoo();

      $(document.body).on("updated_checkout", () => {
        this.initSelectWoo();
      });

      $(document.body).on("change", this.selectSelector, (event) => {
        this.onSelectChange(event);
      });
    },

    /**
     * Initialize SelectWoo.
     *
     * @return {void}
     */
    initSelectWoo: function () {
      $(this.selectSelector).selectWoo();
    },

    /**
     * Handle change event on select.
     *
     * @param {Event} event
     * @return {void}
     */
    onSelectChange: function (event) {
      const select = $(event.target);
      const value = select.val();
      const rateId = select.data("rate-id");

      // If we don't have a value, just return and do nothing.
      if (!value) {
        return;
      }

      const ajaxParams = this.params.ajax.setPickupPoint;

      this.blockElement(".woocommerce-checkout-review-order-table");
      this.blockElement(".woocommerce-checkout-payment");

      // Make a ajax request to the server to update the pickup point.
      $.ajax({
        type: "POST",
        url: ajaxParams.url,
        data: {
          nonce: ajaxParams.nonce,
          rateId: rateId,
          pickupPointId: value,
        },
        success: (response) => {
          this.unblockElement(".woocommerce-checkout-review-order-table");
          this.unblockElement(".woocommerce-checkout-payment");
          // Test if the response is a success or not.
          if (!response.success) {
            console.log(response.data);
          }
        },
        error: (response) => {
          this.unblockElement(".woocommerce-checkout-review-order-table");
          this.unblockElement(".woocommerce-checkout-payment");
          console.log(response);
        },
      });
    },

    /**
     * Blocks the element with the given selector.
     *
     * @param {string} selector
     */
    blockElement: function (selector) {
      $(selector).block({
        message: null,
        overlayCSS: {
          background: "#fff",
          opacity: 0.6,
        },
      });
    },

    /**
     * Unblocks the element with the given selector.
     *
     * @param {string} selector
     */
    unblockElement: function (selector) {
      $(selector).unblock();
    },
  };

  krokedilPickupPointSelect.init();
});
