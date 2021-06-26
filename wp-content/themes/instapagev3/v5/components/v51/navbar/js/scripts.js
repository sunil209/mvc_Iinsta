var InstapageNavbarSticky = function (options) {
  this.options = options;
  this.defaults = {
    selector: '.js-navbar',
    selectorMobile: '.js-navbar-mobile',
    navbarButton: '.js-navbar .js-navbar-btn',
    hamburger: '.js-navbar-hamburger',
    scrollDelay: 200
  };
  Object.assign(this, _.extend(this.defaults, this.options));
};

InstapageNavbarSticky.prototype.init = function () {
  if ((!jQuery(this.selector)[0]) && (!jQuery(this.selectorMobile)[0])) {
    return false;
  }

  this.$navbar = jQuery(this.selector);
  this.$navbarMobile = jQuery(this.selectorMobile);
  this.$navbarHamburger = jQuery(this.hamburger);
  var throttled = InstapageThrottle(this.scrolling.bind(this), this.scrollDelay);

  jQuery(window).scroll(throttled);
  this.$navbarHamburger.on('click', this.toggleMobileNav.bind(this));
  jQuery('.dim').on('click', this.toggleMobileNav.bind(this));
};

InstapageNavbarSticky.prototype.scrolling = function () {
  var scroll = jQuery(window).scrollTop();
  var state = (scroll >= 100) ? this.$navbar.addState('sticky') : this.$navbar.removeState('sticky');
};

InstapageNavbarSticky.prototype.toggleMobileNav = function () {
  this.$navbarMobile.toggleState('open');
  this.$navbarHamburger.toggleState('active');
  jQuery('body').toggleState('locked-mobile');
};
