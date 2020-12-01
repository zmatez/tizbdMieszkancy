<!DOCTYPE HTML>
<html lang="pl">
<body>
<form action="tableform.php" method="post">
    <div class="content-header">
        <h2>Osoby</h2>
    </div>
    <input type="hidden" name="table" value="osoby" />
    <input type="hidden" name="query" value="select * from osoby;" />
    <div class="form-group">
        <input id="form-name" type="text" required="required" maxlength="50" placeholder=" " oninvalid="this.setCustomValidity('Wpisz swoje imie')" oninput="this.setCustomValidity('')" title="Wpisz swoje imie" name="name"/>
        <label class="control-label">Imie</label><i class="bar"></i>
    </div>
    <div class="form-group">
        <input id="form-surname" type="text" required="required" maxlength="200" placeholder=" " oninvalid="this.setCustomValidity('Wpisz swoje nazwisko')" oninput="this.setCustomValidity('')" title="Wpisz swoje nazwisko" name="surname"/>
        <label class="control-label">Nazwisko</label><i class="bar"></i>
    </div>
    <div class="form-group">
        <input id="form-phone" type="text" required="required" maxlength="11" pattern="\d{3}[\-]\d{3}[\-]\d{3}" placeholder=" " oninvalid="this.setCustomValidity('Wpisz swój numer telefonu według wzoru XXX-XXX-XXX')" oninput="this.setCustomValidity(''); phoneFieldChange(this)" onchange="phoneFieldChange(this)" onselect="this.selectionStart = this.selectionEnd;" title="Wpisz swój numer telefonu według wzoru XXX-XXX-XXX" name="phone"/>
        <label class="control-label">Numer telefonu</label><i class="bar"></i>
    </div>
    <div class="button-container">
        <button type="submit" class="button" name="submit" value="add" onclick="loseButtonFocus(this); validateFormsAndPrintError('form',this, 'error-label','form-name','form-surname','form-phone')"><span>Dodaj</span></button>
        <button type="submit" class="button" name="submit" value="show" onclick="loseButtonFocus(this); validateFormsAndPrintError('form',this, 'error-label','form-name','form-surname','form-phone')"><span>Dodaj i zobacz tabelę</span></button>
        <button type="button" class="button" style="background-color: #d07787; border-color: #d07787" onclick="loseButtonFocus(this); showQueryDialog('Mieszkania','select * from osoby;')"><span>Zobacz tabelę</span></button>

    </div>
    <div class="error-container">
        <p id="error-label"></p>
    </div>
</form>
</body>
</html>