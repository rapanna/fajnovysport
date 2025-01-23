 <section class="formular">
 <h2 class="formular__title">Máte dotaz?<br>Neváhejte nás kontaktovat!</h2>
 <form class="formular__form" action="" method="post">
   <div class="form__div">
     <label class="form__label" for="name">Jméno a příjmení (povinné pole)
       <p id="error" class="" role="alert"></p>
     </label>
     <input id="name" class="form__input" type="text" name="name" aria-label="Jméno a příjmení" placeholder="Jméno a příjmení*">
   </div>
   <div class="form__div">
     <label class="form__label" for="email">E-mail (povinné pole)
       <p id="error" class="" role="alert"></p>
     </label>
     <input id="email" class="form__input" type="email" name="email" aria-label="E-mail" placeholder="E-mail*">
   </div>
   <div class="form__div form__div--textarea">
     <label class="form__label" for="message">Zpráva (povinné pole)
       <p id="error" class="" role="alert"></p>
     </label>
     <textarea id="message" class="form__textarea" name="message" aria-label="Zpráva" placeholder="Vaše zpráva*"></textarea>
   </div>
   <div class="form__div form__div--souhlas">
     <input id="souhlas" class="form__checkbox" type="checkbox" name="souhlas" aria-label="Souhlas se zpracováním osobních údajů" />
     <label class="form__label form__label--souhlas" for="souhlas">Souhlas se zpracováním osobních údajů (povinné pole)
     </label>

   </div>
   <div class="form__div form__div--submit">
     <button class="form__submit" type="submit">Odeslat svou zprávu</button>
   </div>
 </form>
</section>
