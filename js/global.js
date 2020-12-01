console.log("Loaded JavaScript file: \"global.js\"");

//BUTTON
function loseButtonFocus(element) {
    setTimeout(function () {
        element.blur();
    }, 500)
}


//PHONE NUMBER
var oldPhoneValue = "";
function phoneFieldChange(element){
    if(element.value.length > oldPhoneValue.length){
        phoneFieldEnter(element);
    }else{
        phoneFieldRemove(element);
    }
}

function phoneFieldEnter(element) {
    let value = element.value;
    if(value.length > 11){
        element.value = oldPhoneValue;
        return;
    }
    let newValue = value;
    let digits = [];
    for (let i = 0; i < 11; i++) {
        if (value.length > i) {
            digits[i] = value.charAt(i);
        } else {
            digits[i] = "null";
        }
    }

    for (let i = 0; i < 11; i++) {
        let char = digits[i];
        if(char === "null"){
            break;
        }else{
            let valid = Boolean(true);
            if(i >= 0 && i < 3){
                if(valid){
                    valid = isNumeric(char)
                }
            }else if(i === 3){
                if(valid){
                    valid = (char === "-");
                    if(!valid){
                        valid = isNumeric(char);
                        if(valid){
                            element.value = value.substring(0,i) + "-" + char;
                            value = element.value;
                            newValue = element.value;
                        }
                    }
                }
            }else if(i >= 4 && i < 7){
                if(valid){
                    valid = isNumeric(char);
                }
            }else if(i === 7){
                if(valid){
                    valid = (char === "-");
                    if(!valid){
                        valid = isNumeric(char);
                        if(valid){
                            element.value = value.substring(0,i) + "-" + char;
                            value = element.value;
                            newValue = element.value;
                        }
                    }
                }
            }else if(i >= 8 && i <= 11){
                if(valid){
                    valid = isNumeric(char);
                }
            }

            if(!valid){
                element.value = oldPhoneValue;
                return ;
            }
        }
    }

    if(value.length===3){
        newValue = value + "-";
    }else if(value.length===7){
        newValue = value + "-";
    }
    oldPhoneValue = newValue;
    element.value = newValue;
}

function phoneFieldRemove(element) {
    let value = element.value;
    let newValue = value;
    if(value.length===4){
        newValue = value.substring(0,3);
    }else if(value.length===8){
        newValue = value.substring(0,7);
    }
    oldPhoneValue = newValue;

    element.value = newValue;
}

//FORM NUMBER
var oldNumberValue = "";
function numberFieldChange(element){
    if(element.value.length > oldNumberValue.length){
        numberFieldEnter(element);
    }else{
        oldNumberValue = element.value;
    }
}

function numberFieldEnter(element) {
    let value = element.value;
    if(!isNumeric(value) || value.includes(".")){
        element.value = oldNumberValue;
        return;
    }

    oldNumberValue =value;
}

//POSTAL CODE
var oldPostalCode = "";
function postalCodeChange(element){
    if(element.value.length > oldPostalCode.length){
        postalCodeEnter(element);
    }else{
        postalCodeFieldRemove(element);
    }
}

function postalCodeEnter(element) {
    let value = element.value;
    if(value.length > 6){
        element.value = oldPostalCode;
        return;
    }
    let newValue = value;
    let digits = [];
    for (let i = 0; i < 6; i++) {
        if (value.length > i) {
            digits[i] = value.charAt(i);
        } else {
            digits[i] = "null";
        }
    }

    for (let i = 0; i < 6; i++) {
        let char = digits[i];
        if(char === "null"){
            break;
        }else{
            let valid = Boolean(true);
            if(i >= 0 && i < 2){
                if(valid){
                    valid = isNumeric(char)
                }
            }else if(i === 2){
                if(valid){
                    valid = (char === "-");
                    if(!valid){
                        valid = isNumeric(char);
                        if(valid){
                            element.value = value.substring(0,i) + "-" + char;
                            value = element.value;
                            newValue = element.value;
                        }
                    }
                }
            }else if(i >= 3 && i <= 5){
                if(valid){
                    valid = isNumeric(char)
                }
            }

            if(!valid){
                element.value = oldPostalCode;
                return ;
            }
        }
    }

    if(value.length===2){
        newValue = value + "-";
    }
    oldPostalCode = newValue;
    element.value = newValue;
}

function postalCodeFieldRemove(element) {
    let value = element.value;
    let newValue = value;
    if(value.length===3){
        newValue = value.substring(0,2);
    }
    oldPostalCode = newValue;

    element.value = newValue;
}

//NUMBER UTILS
function isNumeric(n) { return /^-?[\d.]+(?:e-?\d+)?$/.test(n) && n !== "."; }

function isFloat(n) { return /^-?[\d.]+(?:e-?\d+)?$/.test(n); }

//FORM VALIDATION
function validateFormsAndPrintError(form, button, errorParagraph, ...elements){
    let errorElement = document.getElementById(errorParagraph);
    let formElement = document.getElementById(form);
    let msg = validateForms(...elements);
    let isValid = msg.length === 0;
    if(!isValid) {
        errorElement.style.color = "#fd5d1c";
        errorElement.innerText = msg;
    }else{
        let valid = true;
        for(let i = 0; i < elements.length; i++){
            let element = document.getElementById(elements[i]);
            if(!element.checkValidity()){
                valid = false;
                break;
            }
        }
        if(valid){
            errorElement.style.color = "#fdaa1c";
            errorElement.innerText = "Przetwarzanie...";
        }
    }
    return isValid;
}

function validateForms(...elements){
    let missing = "";
    let missingAmount = 0;
    for(let i = 0; i < elements.length; i++){
        let element = document.getElementById(elements[i]);
        let value = element.value;
        if(value.length===0 && element.hasAttribute("required")){
            let msg = "\""+element.getAttribute("title").toLowerCase() + "\"";
            missing += (missingAmount === 0 ? "" : ", ") + msg;
            missingAmount++;
        }
    }

    if(missingAmount >= 2){
        missing = missing.replace(/,([^,]*)$/, ' i$1');
        missing = "Wypełnij pola w komórkach " + missing;
    }else{
        missing = "Wypełnij pole w komórce " + missing;
    }



    return missingAmount === 0 ? "" : missing + ".";
}

function resetCursor(element){
    element.selectionStart = element.selectionEnd = element.value.length;
}

function getParameterByName(name, url = window.location.href) {
    name = name.replace(/[\[\]]/g, '\\$&');
    var regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, ' '));
}

var showingDialog = Boolean(false);
function showDialog() {
    let dialogWindow = document.getElementById("dialogWindow");
    if (!showingDialog) {
        dialogWindow.style.opacity = "0";
        dialogWindow.style.display = "block";
        dialogWindow.style.transition="opacity 0.5s ease-in-out";
        dialogWindow.style.opacity = "1";

        showingDialog = Boolean(true);
    } else {
        hideDialog();
    }

}

function hideDialog() {
    let dialogWindow = document.getElementById("dialogWindow");
    dialogWindow.style.opacity = "0";
    setTimeout(function () {
        fullyHideDialog(dialogWindow);
    },500);
}

function fullyHideDialog(dialog) {
    dialog.style.display = "none";

    clearTimeout(fullyHideDialog);
    showingDialog=Boolean(false);
}

function showQueryDialog(name, query){
    if(!showingDialog){
        $('#dialogWindow-content').load("forms/dialog.php?query=" + btoa(query) + "&name=" + btoa(name));
        showDialog();
    }
}