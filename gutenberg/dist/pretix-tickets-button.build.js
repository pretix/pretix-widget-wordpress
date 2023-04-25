/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!***************************************************!*\
  !*** ./src/blocks/pretix-tickets-button/index.js ***!
  \***************************************************/
var registerBlockType = wp.blocks.registerBlockType;
var __ = wp.i18n.__;
var Edit = wp.blockEditor.Edit;
var Save = wp.blockEditor.Save;
registerBlockType('pretix-tickets/pretix-tickets-button', {
  title: __('Pretix Tickets Button', 'pretix-tickets'),
  description: __('A button for pretix tickets.', 'pretix-tickets'),
  category: 'widgets',
  icon: 'tickets-alt',
  supports: {
    html: false
  },
  attributes: {
    buttonText: {
      type: 'string',
      "default": ''
    }
  },
  edit: Edit,
  save: Save
});
/******/ })()
;
//# sourceMappingURL=pretix-tickets-button.build.js.map