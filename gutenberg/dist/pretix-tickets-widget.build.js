/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!***************************************************!*\
  !*** ./src/blocks/pretix-tickets-widget/index.js ***!
  \***************************************************/
var registerBlockType = wp.blocks.registerBlockType;
var __ = wp.i18n.__;
var _wp$components = wp.components,
  TextControl = _wp$components.TextControl,
  ToggleControl = _wp$components.ToggleControl;
var _wp = wp,
  serverSideRender = _wp.serverSideRender;
registerBlockType('pretix-tickets/pretix-tickets-widget', {
  title: __('Pretix Tickets Widget', 'pretix-tickets'),
  description: __('A widget for displaying pretix tickets.', 'pretix-tickets'),
  icon: 'tickets-alt',
  category: 'widgets',
  attributes: {
    pretixEvent: {
      type: 'string',
      "default": ''
    },
    subEvent: {
      type: 'string',
      "default": ''
    },
    variant: {
      type: 'string',
      "default": ''
    },
    hideEventTitle: {
      type: 'boolean',
      "default": false
    }
  },
  edit: function edit(_ref) {
    var attributes = _ref.attributes,
      setAttributes = _ref.setAttributes;
    var pretixEvent = attributes.pretixEvent,
      subEvent = attributes.subEvent,
      variant = attributes.variant,
      hideEventTitle = attributes.hideEventTitle;
    var handlePretixEventChange = function handlePretixEventChange(value) {
      setAttributes({
        pretixEvent: value
      });
    };
    var handleSubEventChange = function handleSubEventChange(value) {
      setAttributes({
        subEvent: value
      });
    };
    var handleVariantChange = function handleVariantChange(value) {
      setAttributes({
        variant: value
      });
    };
    var handleHideEventTitleChange = function handleHideEventTitleChange(value) {
      setAttributes({
        hideEventTitle: value
      });
    };
    return /*#__PURE__*/React.createElement("div", null, /*#__PURE__*/React.createElement(TextControl, {
      label: __('Pretix Event Slug', 'pretix-tickets'),
      value: pretixEvent,
      onChange: handlePretixEventChange,
      help: __('Enter the pretix event slug.', 'pretix-tickets')
    }), /*#__PURE__*/React.createElement(TextControl, {
      label: __('Pretix Subevent Slug', 'pretix-tickets'),
      value: subEvent,
      onChange: handleSubEventChange,
      help: __('Enter the pretix subevent slug.', 'pretix-tickets')
    }), /*#__PURE__*/React.createElement(TextControl, {
      label: __('Pretix Variant', 'pretix-tickets'),
      value: variant,
      onChange: handleVariantChange,
      help: __('Enter the pretix variant.', 'pretix-tickets')
    }), /*#__PURE__*/React.createElement(ToggleControl, {
      label: __('Hide Event Title', 'pretix-tickets'),
      checked: hideEventTitle,
      onChange: handleHideEventTitleChange,
      help: __('Hide the event title above the tickets widget.', 'pretix-tickets')
    }));
  },
  save: function save(_ref2) {
    var attributes = _ref2.attributes;
    var pretixEvent = attributes.pretixEvent,
      subEvent = attributes.subEvent,
      variant = attributes.variant,
      hideEventTitle = attributes.hideEventTitle;
    return /*#__PURE__*/React.createElement(Save, {
      pretixEvent: pretixEvent,
      subEvent: subEvent,
      variant: variant,
      hideEventTitle: hideEventTitle
    });
  }
});
/******/ })()
;
//# sourceMappingURL=pretix-tickets-widget.build.js.map