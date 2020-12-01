<!DOCTYPE HTML>
<html lang="pl">

<body>
<form action="tableform.php" method="post">
    <div class="content-header">
        <h2>Mieszkania</h2>
    </div>
    <input type="hidden" name="table" value="mieszkania" />
    <input type="hidden" name="query" value="select * from mieszkania;" />
    <div class="form-group">
        <input id="form-street" type="text" required="required" maxlength="30" placeholder=" " oninvalid="this.setCustomValidity('Wpisz ulicę')" oninput="this.setCustomValidity('')" title="Wpisz ulice" name="street"/>
        <label class="control-label">Ulica</label><i class="bar"></i>
    </div>
    <div class="form-group">
        <input id="form-housenum" type="text" required="required" maxlength="5" placeholder=" " oninvalid="this.setCustomValidity('Wpisz numer domu')" oninput="this.setCustomValidity('');"  title="Wpisz numer domu" name="house-number"/>
        <label class="control-label">Numer domu</label><i class="bar"></i>
    </div>
    <div class="form-group">
        <input id="form-flatnum" type="text" required="required" maxlength="5" placeholder=" " oninvalid="this.setCustomValidity('Wpisz numer mieszkania')" oninput="this.setCustomValidity('');"  title="Wpisz numer mieszkania" name="flat-number"/>
        <label class="control-label">Numer mieszkania</label><i class="bar"></i>
    </div>
    <div class="form-group">
        <input id="form-code" type="text" required="required" pattern="^\d{2}-\d{3}$" maxlength="6" placeholder=" " oninvalid="this.setCustomValidity('Wpisz kod pocztowy')" oninput="this.setCustomValidity(''); postalCodeChange(this)" onchange="postalCodeChange(this)" onselect="this.selectionStart = this.selectionEnd;" title="Wpisz kod pocztowy" name="postal-code"/>
        <label class="control-label">Kod pocztowy</label><i class="bar"></i>
    </div>
    <div class="form-group">
        <input id="form-town" type="text" required="required" maxlength="30" placeholder=" " oninvalid="this.setCustomValidity('Wpisz miejscowość')" oninput="this.setCustomValidity('')" title="Wpisz miejscowość" name="town"/>
        <label class="control-label">Miejscowosc</label><i class="bar"></i>
    </div>

    <div class="button-container">
        <button type="submit" class="button" name="submit" value="add" onclick="loseButtonFocus(this); validateFormsAndPrintError('form',this, 'error-label','form-street','form-housenum','form-flatnum','form-code','form-town')"><span>Dodaj</span></button>
        <button type="submit" class="button" name="submit" value="show" onclick="loseButtonFocus(this); validateFormsAndPrintError('form',this,  'error-label','form-street','form-housenum','form-flatnum','form-code','form-town')"><span>Dodaj i zobacz tabelę</span></button>
        <button type="button" class="button" style="background-color: #d07787; border-color: #d07787" onclick="loseButtonFocus(this); showQueryDialog('Mieszkania','select * from mieszkania;')"><span>Zobacz tabelę</span></button>

    </div>
    <div class="error-container">
        <p id="error-label"></p>
    </div>
</form>
</body>
</html>