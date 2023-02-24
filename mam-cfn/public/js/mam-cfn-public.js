// noinspection JSUnresolvedVariable

jQuery(document).ready(function ($) {
    /**
     * This function saves cookies for the user's utm_source, utm_medium, and utm_campaign parameters.
     */
    function mam_utm_save_cookies() {
        // Get the referral for the current page using the mamGetReferral function.
        const mam_utm_referral = mam_get_referral();

        // Save the utm_source parameter in a cookie.
        let user_utm_source = mam_get_parameter_by_name('utm_source');
        if (user_utm_source) {
            Cookies.set('user_utm_source', user_utm_source);
        }

        // If the user_utm_source cookie is not set or is set to 'Direct', generate an automated cookie based on the referral.
        if (!Cookies.get('user_utm_source') || Cookies.get('user_utm_source') === 'Direct') {
            if (mam_utm_referral !== '') {
                Cookies.set('user_utm_source', 'Referral');
            } else {
                Cookies.set('user_utm_source', 'Direct');
            }
        }

        // Save the utm_medium parameter in a cookie.
        let user_utm_medium = mam_get_parameter_by_name('utm_medium');
        if (user_utm_medium) {
            Cookies.set('user_utm_medium', user_utm_medium);
        }

        // If the user_utm_medium cookie is not set or is set to '-', generate an automated cookie based on the referral.
        if (!Cookies.get('user_utm_medium') || Cookies.get('user_utm_medium') === '-') {
            if (mam_utm_referral !== '') {
                Cookies.set('user_utm_medium', mam_utm_referral);
            } else {
                Cookies.set('user_utm_medium', '-');
            }
        }

        // Save the utm_campaign parameter in a cookie.
        let user_utm_campaign = mam_get_parameter_by_name('utm_campaign');
        if (user_utm_campaign) {
            Cookies.set('user_utm_campaign', user_utm_campaign);
        }

        // If the user_utm_campaign cookie is not set, generate an automated cookie with a value of '-'.
        if (!Cookies.get('user_utm_campaign')) {
            Cookies.set('user_utm_campaign', '-');
        }
    }


    /**
     * This function checks the referrer of the current page and returns it if it meets certain conditions.
     */
    function mam_get_referral() {
        if (!document.referrer) {
            // If there is no referrer, return an empty string.
            return '';
        } else {
            // If there is a referrer, check if it includes the current domain.
            // mam_utm.current_domain is coming from wp_localize_script.
            if (document.referrer.includes(mam_extract_domain(window.location.href))) {
                // If the referrer includes the current domain, return an empty string.
                return '';
            }
            // If the referrer doesn't include the current domain, return the referrer.
            return document.referrer;
        }
    }


    /**
     * This function extracts the domain name from a given URL string.
     */
    function mam_extract_domain(url) {
        var domain;

        // Check if the URL contains a protocol (e.g. "http://" or "https://").
        // If it does, split the URL by the forward slashes and take the second element, which should be the domain.
        // If it doesn't contain a protocol, take the first element as the domain.
        if (url.indexOf("://") > -1) {
            domain = url.split('/')[2];
        } else {
            domain = url.split('/')[0];
        }

        // Remove any port number if it exists by splitting the domain by any colon.
        domain = domain.split(':')[0];

        // Remove any query parameters by splitting the domain by any question mark.
        domain = domain.split('?')[0];

        // Return the resulting string as the domain.
        return domain;
    }

    /**
     * Get the value of a query parameter by its name from the current URL.
     *
     * @param {string} name - The name of the query parameter to retrieve.
     * @return {string|null} - The value of the query parameter if it exists, or null if it does not.
     */
    function mam_get_parameter_by_name(name) {
        // Get the current URL.
        const url = window.location.href;

        // Escape any special characters in the name of the query parameter.
        name = name.replace(/[\[\]]/g, "\\$&");

        // Construct a regular expression to match the query parameter in the URL.
        const regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)");

        // Execute the regular expression on the URL to find the query parameter and its value.
        const results = regex.exec(url);

        // If the query parameter was not found, return null.
        if (!results) return null;

        // If the query parameter was found but has no value, return an empty string.
        if (!results[2]) return '';

        // Decode the value of the query parameter and return it.
        return decodeURIComponent(results[2].replace(/\+/g, " "));
    }

    // from the plugin wp_localize_script
    // noinspection JSUnresolvedVariable
    const cfn_options = mam_cfn.phone_numbers;

    /**
     * Runs the Click To Call plugin based on the given options.
     * If conditions are met for a given phone number, replaces phone numbers in text and links on the page.
     */
    function mam_cfn_run() {
        // Check if the Click To Call options are defined
        if (typeof cfn_options !== "undefined") {
            // Check if there are any phone numbers in the options array
            if (cfn_options.length > 0) {
                // Loop through each phone number in the options array
                $.each(cfn_options, function (index, phone_number) {
                    // Get the conditions for the current phone number
                    let conditions = phone_number.conditions;
                    // Check if there are any conditions for the current phone number
                    if (typeof conditions !== "undefined") {
                        if (conditions.length > 0) {
                            // Loop through each condition for the current phone number
                            // If the conditions are met for the current phone number, replace the phone numbers in text and links
                            if (mam_cfn_check_conditions(conditions)) {
                                // Replace phone numbers in text
                                mam_cfn_replace_text(phone_number.numbers, phone_number.replace_with_text);
                                // Replace phone numbers in links
                                mam_cfn_replace_links(phone_number.links, phone_number.replace_with_link);
                            }
                        }
                    }
                });
            }
        }
    }

    /**
     * A function that replaces a certain text with a new text across multiple HTML elements.
     *
     * @param {Array} numbers - An array of objects, each containing a text property representing the text to be replaced.
     * @param {string} replace_with_text - The text to replace the existing text with.
     * @returns {void}
     */
    function mam_cfn_replace_text(numbers, replace_with_text) {
        // An array of HTML elements to search for the text to be replaced
        const elements = ['span', 'p', 'a', 'button'];

        // Iterate through each object in the numbers array, and for each element in the elements array, replace the text
        $.each(numbers, function (index, number) {
            $.each(elements, function (index, element) {
                $(element).each(function () {
                    $(this).html($(this).html().replace(number.text, replace_with_text));
                });
            });
        });
    }

    /**
     * Replaces links that match the provided links with the specified URL.
     *
     * @param {Array} links - An array of link objects to replace.
     * @param {string} replace_with_link - The URL to replace the links with.
     */
    function mam_cfn_replace_links(links, replace_with_link) {
        // Iterate through each link to replace.
        $.each(links, function (index, _link) {
            // Iterate through each link on the page.
            $('a').each(function () {
                // If the link matches the link to replace, update the href attribute with the new URL.
                if ($(this).attr('href') === _link.link) {
                    $(this).attr('href', replace_with_link);
                }
            });
        });
    }


    /**
     * Checks if the given conditions are met by comparing them against the current URL and tracking information stored in cookies.
     *
     * @param {Array} conditions - an array of conditions to be evaluated
     * @returns {boolean} - true if all conditions are met, false otherwise
     */
    function mam_cfn_check_conditions(conditions) {
        let result = false;
        // loops through each condition
        $.each(conditions, function (index, condition) {
            // retrieves the type and value of the current condition
            let type = condition.select_condition;
            let value = '';
            if (typeof condition.value !== "undefined") {
                value = condition.value;
            }

            // evaluates the current condition based on its type
            switch (type) {
                case 'Always':
                    result = true;
                    break;
                case 'Match Current URL':
                    result = window.location.href.includes(value) || window.location.href === value;
                    break;
                case 'Match UTM Source':
                    if (Cookies.get('user_utm_source').includes(value) || Cookies.get('user_utm_source') === value) {
                        result = true;
                    }
                    break;
                case 'Match UTM Campaign':
                    if (Cookies.get('user_utm_campaign').includes(value) || Cookies.get('user_utm_campaign') === value) {
                        result = true;
                    }
                    break;
                case 'Match UTM Medium':
                    if (Cookies.get('user_utm_medium').includes(value) || Cookies.get('user_utm_medium') === value) {
                        result = true;
                    }
                    break;
                default:
                    result = false;
            }
        });

        // returns the overall result of the conditions evaluation
        return result;
    }

    mam_utm_save_cookies();
    mam_cfn_run();
});