/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 1);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/views/assets/js/scripts.js":
/*!**********************************************!*\
  !*** ./resources/views/assets/js/scripts.js ***!
  \**********************************************/
/*! no static exports found */
/***/ (function(module, exports) {

window.Mercadopago.setPublishableKey("TEST-33d6d38f-395c-4f24-a9e7-2267ddf4d259");
window.Mercadopago.getIdentificationTypes();
document.getElementById("paymentMethod").selectedIndex = '0';
document.getElementById('paymentMethodId').value = '';
document.getElementById('detalheCartao').style.display = 'none';
document.getElementById('paymentMethod').addEventListener('change', function (event) {
  console.log('FORMA DE PAGAMENTO: ', event.target.value);

  if (event.target.value == 1) {
    $('#detalheCartao').fadeIn(500);
  } else {
    $('#detalheCartao').fadeOut(500);
    document.getElementById('paymentMethodId').value = 'bolbradesco';
  }
});
document.getElementById('cardNumber').addEventListener('change', guessPaymentMethod);

function guessPaymentMethod(event) {
  cleanCardInfo();

  if (document.getElementById('paymentMethod').value == 1) {
    var cardnumber = document.getElementById("cardNumber").value;

    if (cardnumber.length >= 6) {
      var bin = cardnumber.substring(0, 6);
      window.Mercadopago.getPaymentMethod({
        "bin": bin
      }, setPaymentMethod);
    }
  }
}

;

function setPaymentMethod(status, response) {
  if (status == 200) {
    var paymentMethod = response[0];
    console.log('PAYMENT METHOD: ', paymentMethod);
    document.getElementById('paymentMethodId').value = paymentMethod.id;
    getIssuers(paymentMethod.id);
  } else {
    alert("payment method info error: ".concat(response));
  }
}

function getIssuers(paymentMethodId) {
  window.Mercadopago.getIssuers(paymentMethodId, setIssuers);
}

function setIssuers(status, response) {
  if (status == 200) {
    var issuerSelect = document.getElementById('issuer');
    issuerSelect.options.length = 0;
    response.forEach(function (issuer) {
      var opt = document.createElement('option');
      opt.text = issuer.name;
      opt.value = issuer.id;
      issuerSelect.appendChild(opt);
    });
    getInstallments(document.getElementById('paymentMethodId').value, document.getElementById('transactionAmount').value, issuerSelect.value);
  } else {
    alert("issuers method info error: ".concat(response));
  }
}

function getInstallments(paymentMethodId, transactionAmount, issuerId) {
  window.Mercadopago.getInstallments({
    "payment_method_id": paymentMethodId,
    "amount": parseFloat(transactionAmount),
    "issuer_id": parseInt(issuerId)
  }, setInstallments);
}

function setInstallments(status, response) {
  if (status == 200) {
    document.getElementById('installments').options.length = 0;
    response[0].payer_costs.forEach(function (payerCost) {
      var opt = document.createElement('option');
      opt.text = payerCost.recommended_message;
      opt.value = payerCost.installments;
      document.getElementById('installments').appendChild(opt);
    });
  } else {
    alert("installments method info error: ".concat(response));
  }
}

doSubmit = false;
document.getElementById('paymentForm').addEventListener('submit', getCardToken);

function getCardToken(event) {
  if (document.getElementById('paymentMethod').value == 1) {
    event.preventDefault();

    if (!doSubmit) {
      var $form = document.getElementById('paymentForm');
      window.Mercadopago.createToken($form, setCardTokenAndPay);
      return false;
    }
  }
}

;

function setCardTokenAndPay(status, response) {
  if (status == 200 || status == 201) {
    var form = document.getElementById('paymentForm');
    var card = document.createElement('input');
    card.setAttribute('name', 'token');
    card.setAttribute('type', 'hidden');
    card.setAttribute('value', response.id);
    form.appendChild(card);
    doSubmit = true;
    form.submit();
  } else {
    alert("Verify filled data!\n" + JSON.stringify(response, null, 4));
  }
}

;

function cleanCardInfo() {
  document.getElementById('issuer').options.length = 0;
  document.getElementById('installments').options.length = 0;
}

/***/ }),

/***/ 1:
/*!****************************************************!*\
  !*** multi ./resources/views/assets/js/scripts.js ***!
  \****************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /Applications/MAMP/htdocs/Projetos/TesteCloudFox/resources/views/assets/js/scripts.js */"./resources/views/assets/js/scripts.js");


/***/ })

/******/ });