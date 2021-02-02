define(
    [
        'mage/storage',
    ],
    function (
        storage,
    ) {
        'use strict';
        return function (donationData, totalDonation) {
            return storage.post(
                'donation/ajax/save',
                JSON.stringify(donationData),
                false
            ).done(
                function (response) {
                    return response;
                }
            ).fail(
                function (response) {
                    return response;
                }
            );
        };
    }
);