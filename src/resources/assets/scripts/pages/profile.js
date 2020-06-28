/**
 * @module pageProfile
 * @param sandbox
 * @returns {{init: ((function(*))|*), destroy: ((function())|*)}}
 */
module.exports = function (sandbox) {
    var _this = this;

    _this.init = (data) => {
        if($('#box_basic_information').length){
            sandbox.sub.register("boxBasicInformation", require("../modules/profile.box-basic-information.js"));
        }

        if($('#box_personal_contact_info').length){
            sandbox.sub.register("boxPersonalContactInfo", require("../modules/profile.box-personal-contact-info.js"));
        }

        if($('#box_security').length){
            sandbox.sub.register("boxSecurity", require('../modules/profile.box-security'));
        }

        if($('#box_specialities').length){
            sandbox.sub.register("boxSecurity", require('../modules/profile.box-specialities'));
        }

        if($('#box_colleges').length){
            sandbox.sub.register("boxColleges", require('../modules/profile.box-colleges'));
        }

        if($('#box_qualifications').length){
            sandbox.sub.register("boxQualifications", require('../modules/profile.box-qualifications'));
        }

        sandbox.sub.start();
    }

    _this.destroy = () => {}

    return {
        init: _this.init,
        destroy: _this.destroy
    }
}