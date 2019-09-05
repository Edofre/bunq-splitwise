// Load the Lang library
var Lang = require('lang.js');
// Load all the JSON messages
var messages = require('../data/messages.json');

// Create a new lang object with our required locale and messages
var lang = new Lang();
lang.setLocale('en');
lang.setMessages(messages);

// Create a Vue filter so we can use the " | trans" filter syntax
Vue.filter('translate', (...args) => {
    return lang.get(...args);
});
