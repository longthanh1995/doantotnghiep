/**
 *  Scripts that use for all pages
 */
window.common = {};

/**
* Returns the version of Internet Explorer or a -1
* (indicating the use of another browser).
*/
common.getInternetExplorerVersion = function() {
    var rv = -1; // Return value assumes failure.

    if (navigator.appName == 'Microsoft Internet Explorer') {
        var ua = navigator.userAgent;
        var re = new RegExp("MSIE ([0-9]{1,}[\.0-9]{0,})");
        if (re.exec(ua) != null)
            rv = parseFloat(RegExp.$1);
    }

    return rv;
}

// TODO: Need optimize?
common.initItemPropertyValuesGroup = function () {
    if ($('.item-property-values-group').length > 0) {
        $('.item-property-values-group').each(function () {
            var $this = $(this);

            $(this).find('.item-property-values-group-select').on('click', '.adr.property-select input', function () {
                var $parent = $(this).parent();
                $parent.closest('.owl-wrapper').find('.adr.property-select').removeClass('active');
                $parent.addClass('active');

                var $content = $this.find('.item-property-values-group-content#' + $parent.attr('id') + '_content');
                $content.addClass('active').siblings().removeClass('active');
                /* khong cho active ngay luc dau
                if (0 === $content.find('.adr.property-select input:checked').length) {
                    $content.find('.adr.property-select input').first().prop('checked', true);
                }
                */
            });
        });
    }
}

common.carouselPropertyValues = function () {
    if ($("#carousel-property-values").length > 0) {
        $("#carousel-property-values").owlCarousel({
            items: 7,
            itemsDesktopSmall: [1270, 5],
            slideSpeed: 1000,
            pagination: false,
            navigation: true,
            navigationText: ['', '']
        });
    };
}

// TODO: Need optimize?
/**
* summary: Show or hide overlay [Use on 'detail' & 'cart' page]
*/
common.showHideOverlay = function (type, isCheckout) {        
    var btCheckOut = $(".adr.pull-right.bg-red.large.button.cart-purchase-button");
    var btAddToCart = $("#top_shopping_button");
    var divOverlay = $(".product-details-overlay");

    if (type == 1) /* show*/ {
        divOverlay.removeClass("hide");
        btAddToCart.find("i").removeClass("adr-icon-shop-cart").addClass("huge loading-bg-bold-red");

        if (isCheckout !== "undefined" && isCheckout == true) // For checkout
            btCheckOut.find("img").attr("src", "/images/icons/adr-icon-compact-loading-bg-red.gif");
    }
    else {
        divOverlay.addClass("hide");
        btAddToCart.find("i").removeClass("huge loading-bg-bold-red").addClass("adr-icon-shop-cart");
        btCheckOut.find("img").attr("src", "/images/icon_image/nav-right.png");
    }
},

/*
* pushNotify
* summary: Show message notification
* author:
* param {string} message - Message content
* param {string} type -  warning, error..
*/
common.pushNotify = function (message, type) {
    //if ($("#notification_container").html())
    //    return;

    if (!type)
        type = "warning";

    var icon = 'adr huge icon notification-' + type;
    $.notify({
        message: message,
        icon: icon
    }, {
        element: '#notification_container',
        type: type,
        offset: { x: 8, y: 8 },
        delay: 5000,
        position: 'static',
        template: '<div data-notify="container" class="adr alert alert-{0}" role="alert">' +
            '<button type="button" aria-hidden="true" class="close" data-notify="dismiss">×</button>' +
            '<span class="notify-icon" data-notify="icon"></span> ' +
            '<span data-notify="title">{1}</span> ' +
            '<span data-notify="message">{2}</span>' +
            '<a href="{3}" target="{4}" data-notify="url"></a>' +
        '</div>'
    });
},

/**
* summary: Page Product Details - Add index to widget_best_sellings items - for styling on IE7 redefine function activeItemDropdown() (old one commented)
*/
common.activeItemDropdown = function () {
    $('.dropdown .dropdown-menu li').click(function (event) {
        $('.dropdown .dropdown-menu li').removeClass('active');
        $(this).toggleClass('active');
    });
},

common.changeMerchant = function () {
    $('.dropdown.store-local .dropdown-menu li').click(function (event) {
        event.preventDefault();
        var $htmlString = $(this).find('a').data('name') + " - " + $(this).find('a').data('addr');
        $(this).closest('.dropdown').find('.value').html($htmlString);
    });
}

/**
* summary: Use in product details page
*/
common.initToggleMerchantDescription = function () {
    $('#other_merchants_list').adrToggle({
        trigger: '#other_merchants_list_toggle',
        type: 'max-height',
        value: 185
    });

    $('#product_excerpt').adrToggle({
        trigger: '#product_excerpt_toggle',
        type: 'max-height',
        value: 60
    });

    $('#other_merchants_list_1024').adrToggle({
        trigger: '#other_merchants_list_1024_toggle',
        type: 'visibility'
    });
}


common.pushStateUrl = function(newUrl) {
    try {
        window.history.pushState(null, null, newUrl);
    }
    catch (e) {
        //console.log('pushStateUrl method: ', newUrl);
    }
}

/*Page Product Details - Add index to widget_best_sellings items - for styling on IE7*/
common.indexWidgetBestSellings = function() {
    if ($('#widget_best_sellings').length > 0) {
        $('#widget_best_sellings').each(function () {
            $(this).find('.item').each(function (index) {
                $(this).addClass('index' + index);

                if (($(this).index() % 2) == 0) {
                    $(this).addClass('first');
                };
            });
        });
    }
}

/* Start Cart */

common.adrScrollBar = function () {
    if ($(".wrapScrollBar").length > 0) {
        $(".wrapScrollBar").each(function () {
            $(this).mCustomScrollbar({
                theme: "dark-thick",
                advanced: {
                    updateOnContentResize: true
                },
                scrollInertia: 200
            });
        });
    }
}

common.allowNumber = function () {
    /* kiem tra Ctrl + V, Ctrl + C */
    var ctrlDown = false;
    var ctrlKey = 17, vKey = 86, cKey = 67;
    $(".form-control.quantity, #pStockQuantity").keypress(function (e) {
        if (e.which != 13 && e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
            return false;
        }
    });

    $(document).keydown(function (e) {
        if (e.keyCode == ctrlKey) ctrlDown = true;
    }).keyup(function (e) {
        if (e.keyCode == ctrlKey) ctrlDown = false;
    });
    $(".form-control.quantity, #pStockQuantity").keydown(function (e) {
        if (ctrlDown && (e.keyCode == vKey || e.keyCode == cKey)) {
            return false;
        }
    });
    /* - End - */
}

common.changePositionDropdown = function () {
    $('.cart .dropdown > span').click(function () {
        var $this = $(this).parent();
        setTimeout(function () {
            if ($this.hasClass("open")) {
                if ($this.closest("#wrapScrollBar").hasClass("wrapScrollBar")) {
                    var offset = $('.modal-footer.cart-footer').offset();
                    var offset2 = $this.find('.dropdown-menu').offset();
                    var x = $this.find('.dropdown-menu').outerHeight();

                    if ((offset.top - offset2.top) < x) {
                        $this.find('.dropdown-menu').css({
                            'top': "auto",
                            'bottom': '100%',
                            'margin': '0 0 2px 0'
                        });
                    }
                    else if ((offset.top - offset2.top) > (2 * x)) {
                        $this.find('.dropdown-menu').css({
                            'top': "100%",
                            'bottom': 'auto',
                            'margin': '2px 0 0 0'
                        });
                    }
                } else {
                    $this.find('.dropdown-menu').css({
                        'top': "100%",
                        'bottom': 'auto',
                        'margin': '2px 0 0 0'
                    });
                }
            }
        }, 300);
    });
}

common.changeStatusIncrementer = function (id, qtyChange, qtyStock) {    
    try {
        $(id).val(qtyChange);
        var maxDDLBuyTemp = maxDDLBuy;
        if ($(id).hasClass("popup")) {
            maxDDLBuyTemp = maxDDLBuyTemp / 2;
        }
        if (qtyChange <= maxDDLBuyTemp) {
            $(id).removeClass("show");
            $(id).parent().find(".dropdown").removeClass("hide").addClass("show");
            $(id).parent().find(".value").text(qtyChange);
            $(id).parent().find(".dropdown-menu li").removeClass("active");
            $(id).parent().find(".dropdown-menu li").each(function () {
                var $this = $(this);
                if ($this.attr("class") != "more-count-item") {
                    if (eval($this.text()) === qtyChange) {
                        $this.addClass("active");
                    }
                }
            });
        }
        else {
            $(id).parent().find(".dropdown").removeClass("show").addClass("hide");
            $(id).removeClass("hide").addClass("show");
        }
    }
    catch (e) {

    }
};

common.changePositionDropdown = function () {
    $('.cart .dropdown > span').click(function () {
        var $this = $(this).parent();
        setTimeout(function () {
            if ($this.hasClass("open")) {
                if ($this.closest("#wrapScrollBar").hasClass("wrapScrollBar")) {
                    var offset = $('.modal-footer.cart-footer').offset();
                    var offset2 = $this.find('.dropdown-menu').offset();
                    var x = $this.find('.dropdown-menu').outerHeight();

                    if ((offset.top - offset2.top) < x) {
                        $this.find('.dropdown-menu').css({
                            'top': "auto",
                            'bottom': '100%',
                            'margin': '0 0 2px 0'
                        });
                    }
                    else if ((offset.top - offset2.top) > (2 * x)) {
                        $this.find('.dropdown-menu').css({
                            'top': "100%",
                            'bottom': 'auto',
                            'margin': '2px 0 0 0'
                        });
                    }
                } else {
                    $this.find('.dropdown-menu').css({
                        'top': "100%",
                        'bottom': 'auto',
                        'margin': '2px 0 0 0'
                    });
                }
            }
        }, 300);
    });
}

/* End Cart */

Number.prototype.format = function (n, x) {
    var re = '\\d(?=(\\d{' + (x || 3) + '})+' + (n > 0 ? '\\.' : '$') + ')';
    return this.toFixed(Math.max(0, ~~n)).replace(new RegExp(re, 'g'), '$&.');
};

$.fn.setCursorPosition = function (pos) {
    this.each(function (index, elem) {
        if (elem.setSelectionRange && !$(elem).is(":hidden")) {
            elem.setSelectionRange(pos, pos);
        } else if (elem.createTextRange) {
            var range = elem.createTextRange();
            range.collapse(true);
            range.moveEnd('character', pos);
            range.moveStart('character', pos);
            range.select();
        }
    });
    return this;
};
if ($('#pStockQuantity').val() > 1) {
    $('#pStockQuantity').focus().setCursorPosition(1);
}


/**     
 * @description: get attribute requirement [only on action 'addItem']
 * @param {Object} lstAttributeIds: get from attribute product
          {Object} generalAttribute: get from attribute product
 */
common.getAttributeRequirement = function (lstAttributeIds, generalAttribute) {
    var result = {};
    var selectedVariations = [];

    if (typeof (lstAttributeIds) != 'undefined' && lstAttributeIds != null) {
        var variationNames = lstAttributeIds;

        $.each(variationNames, function () {
            var _this = $('#variation_' + this);
            var selectedProperty = {
                'attribute': $('.item-property-label', _this).first().text(),
                'value': $('[name="' + this + '"]:checked', _this).next().text()
            };
            if (selectedProperty.value)
                selectedVariations.push(selectedProperty);
        });
    }
    result.requirementAttribute = selectedVariations;

    if (typeof generalAttribute !== 'undefined')
        result.generalAttribute = generalAttribute;

    return JSON.stringify(result);
}

/**     
 * @description: get attribute name [only on action 'addItem']
 * @param {Object} productTypeFreshFood: get from attribute product
          {Object} lstAttributeIds: get from attribute product
 */
common.getAttributeNames = function (productTypeFreshFood, lstAttributeIds) {
    var dataString = '';
    if (productTypeFreshFood != 1) {

        if (typeof (lstAttributeIds) != 'undefined' && lstAttributeIds != null) {
            var variationNames = lstAttributeIds;
            var selectedVariations = [];

            $.each(variationNames, function () {
                var _this = $('#variation_' + this);
                var selectedProperty = {
                    'attribute': $('.item-property-label', _this).first().text(),
                    'value': $('[name="' + this + '"]:checked', _this).next().text()
                };

                if (selectedProperty.value)
                    selectedVariations.push(selectedProperty);
            });

            $.each(selectedVariations, function () {
                dataString += this.attribute + ': ' + this.value + ', ';
            });
        }

        if (dataString != '')
            dataString = dataString.substring(0, dataString.length - 1);

    }
    else
        dataString = $("#item_prices_2 .text.weight").html();

    return dataString;
}

String.prototype.supplant = function (o) {
    return this.replace(/{([^{}]*)}/g,
        function (a, b) {
            var r = o[b];
            return typeof r === 'string' || r === null || typeof r === 'number' ? r : a;
        }
    );
};

(function ($) {
    $.fn.escapeHtml = function () {
        var ua = navigator.userAgent;
        var re = new RegExp("MSIE ([0-9]{1,}[\.0-9]{0,})");
        var e = document.createElement("div"),
        s = '';
        $(e).text($(this).val() || $(this).html() || $(this).text());
        s = $(e).text();
        if (re.exec(ua) != null) {
            $(e).remove();
        } else {
            try {
                e.remove();
            }
            catch (e) { }
        }
        return s.replace(/<\/?([a-z][a-z0-9]*)\b[^>]*>?/gi, '');
    };
})(jQuery);

//@TODO: temporarily variable, need refactor later
global.last_clicked_RedeemVPBank = 0;
common.redeemVPBank = function () {
    var time_since_clicked_RedeemVPBank;
    if (global.last_clicked_RedeemVPBank) 
        time_since_clicked_RedeemVPBank = jQuery.now() - global.last_clicked_RedeemVPBank;
    
    global.last_clicked_RedeemVPBank = jQuery.now();
    
    if (time_since_clicked_RedeemVPBank < 2000) {
        /*Disable double click*/
    } else {
        var $frm = $('#frmVPBank');
        var redeemCode = $("#txtCredit").escapeHtml();
        var code = $("#txtCode").val();
        if ($frm.valid()) {
            $.ajax({
                url: '/VPBank/RedeemCode',
                type: "POST",
                headers: {
                    'RequestVerificationToken': globalData.tokenHeaderValue
                },
                data: { userId: globalData.user.id, email: globalData.user.email, redeemCode: redeemCode, campCode: code }
            }).
            done(function (data) {
                //console.log(data.Status, data.Message, data.Status >= 0 && (data.Message === '' || data.Message === null));
                if (data.Status >= 0 && (data.Message === '' || data.Message === null)) {
                    var tempdata = "";

                    tempdata += "	            <div class=\"modal-content green\">";
                    tempdata += "	                <div class=\"modal-header\">";
                    tempdata += "	                    <button aria-label=\"Close\" data-dismiss=\"modal\" class=\"close\" type=\"button\" onclick=\"clearForm()\"><\/button>";
                    tempdata += "	                    <h4 id=\"checkOrderLabel\" class=\"modal-title\">Thông báo thành công<\/h4>";
                    tempdata += "	                    <div class=\"w-circle\">";
                    tempdata += "	                        <span class=\"circle\"><img src=\"\/images\/bank\/card.png\" \/><\/span>";
                    tempdata += "	                    <\/div>";
                    tempdata += "	                <\/div>";
                    tempdata += "<form role=\"form\" action=\"\/\">";
                    tempdata += "	<div class=\"modal-body text-center\">";
                    tempdata += "		<h3>Chúc mừng bạn đã đổi điểm thành công<\/h3>";
                    tempdata += "		<p>Bạn có thêm <strong class=\"color-red\">" + data.Status + "<\/strong> điểm Adayroi.<\/p>";
                    tempdata += "		<a class=\"adr button bg-red\" href=\"/\">Click để mua sắm<\/a>	";
                    tempdata += "	<\/div>";
                    tempdata += "	<div class=\"modal-footer mtop-32\">";
                    tempdata += "		<div class=\"modal-footer-content text-center\">";
                    tempdata += "			<a  target=\"_blank\" href=\"" + userUrl + "/Credit/GeneralInfo\">Xem chi tiết tài khoản<\/a>";
                    tempdata += "		<\/div>                      ";
                    tempdata += "	<\/div>";
                    tempdata += "<\/form>";
                    tempdata += "	            <\/div>";

                    $('#convert-score').html(tempdata.supplant(data.Status));
                    $('#convert-score').modal('show');
                    
                    common.clearForm('#frmVPBank');
                    common.clearValidationUI('#frmVPBank');
                    $frm.find('div.validation').text('');
                } else {
                    $('#card-adayroi form .validation').text(data.Message);
                }
            })
            .error(function(xhr, status) {
            });
        }
    }
};

common.clearForm = function(formId) {
    if (typeof $(formId)[0] != 'undefined') {
        $(formId)[0].reset();
        $(formId + ' .form-group').removeClass("has-error");
    }
};

common.clearValidationUI = function (formId) {
    $(formId + " label.error").remove();
    $(formId + " .error").removeClass('error');
    $(formId)[0].reset();
    $(formId + "input[type=text]").val('');
};

/**
 * Prevent back state
 * make sure that no features using hash
 */
common.preventBack = function(hash){
    window.location.hash = hash || 'pleaseDontPressBack';
    window.onhashchange = function(event){
        event.preventDefault();
        window.location.hash = hash || 'pleaseDontPressBack';
    }

}

module.exports = common;