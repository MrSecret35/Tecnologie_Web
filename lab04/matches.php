<?php include "top.html"; ?>
<!-- form utilizzata per la ricerca delle personalità affini ad un utente che specificherà il propio username nella form -->
<form action="matches-submit.php" method="get">
<fieldset>
    <legend>Returning User</legend>     
        <ul>
            <li><strong>Name:</strong>
            <label class="colums"><input name="name" type="text" maxlength=16 > </label>
            </li>
        </ul>
        <input type="submit" value="View my Matches">
</fieldset>
</form>
<?php include "bottom.html"; ?>