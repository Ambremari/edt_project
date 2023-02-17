@if ($errors->any())
    <div class="alert alert-warning">
        La connexion a échouée;
    </div>  
@endif
<div class="my_input">
    <p><label for="id" >Identifiant</label></p>
    <input type="text" id="id" name="id" minlength="2" maxlength="10"
        aria-describedby="id_feedback"
        style="width:200px"
        value="{{ old('id') }}" required>
</div>
@error('id')
<div id="id_feedback" class="invalid-feedback">
    {{ $message }}
</div>
@enderror
<div class="my_input">
    <p><label for="password">Mot de passe</label></p>
    <input type="password" id="password" name="password" minlength="2"
        aria-describedby="password_feedback"
        style="width:200px"
        value="{{ old('password') }}" required>
</div>
@error('password')
<div id="password_feedback" class="invalid-feedback">
    {{ $message }}
</div>
@enderror
<button type="submit">Connexion</button>