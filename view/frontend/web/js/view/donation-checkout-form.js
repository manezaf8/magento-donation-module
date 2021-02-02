/*global define*/
define([
    'jquery',
    'ko',
    'uiComponent',
    'Magento_Ui/js/form/form',
    'mage/validation',
    'Magento_Ui/js/modal/alert',
    'Sqli_Donation/js/view/action/save-donation'
], function (
        $,
        ko,
        Component,
        validation,
        totalDonation,
        malert,
        saveAction
    ) {
    'use strict';
        return Component.extend({
            
        initialize: function () {

            this.donationAmount = ko.observableArray([]);
            this.donationData = ko.observable('');
            this._super();
            // component initialization logic
            return this;
        },

        save: function (saveForm) {
            var self = this;
            var saveData = {},
                formDataArray = $(saveForm).serializeArray();

            formDataArray.forEach(function (entry) {
                saveData[entry.name] = entry.value;
            });

            if ($(saveForm).validation()
                && $(saveForm).validation('isValid')
            ) {
                saveAction(saveData, totalDonation).always(function () {
                    console.log(totalDonation()); //delete this line later
                });
            }

            if (!saveData && !totalDonation) {
                malert({
                    title: 'Error',
                    content: 'Some error occured. Please try again later.',
                    clickableOverlay: false,
                    actions: {
                        always: function () { }
                    }
                });
            } else {
                malert({
                    title: 'Success',
                    content: 'Thanks for donating, Happy shopping!',
                    clickableOverlay: false,
                    actions: {
                        always: function () { }
                    }
                });
              }
            },
        
            getTotalDonation: function () {
                return totalDonation;
            },

           showAmountField: function () {

            $("#showAmountFieldId").click(function () {
                $("#amountField").toggle(800);
                $("#buttonField").toggle(1000);
            });
            console.log('Show the form'); //delete the this line
            },
           
           
    });
});