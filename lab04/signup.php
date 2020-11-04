<?php include "top.html"; ?>
<!-- form utilizzata per l'iscrizione di un utente -->
<form action="signup-submit.php" method="post">
<fieldset>
    <legend>New User Signup</legend>
        
        <ul>
            <li ><strong>Name:</strong>
                <input name="name" type="text" maxlength=16 size=20>
            </li>
            <li ><strong>Gender:</strong>
                <label ><input name="S" value="M" type="radio" > Male</label>
                <label ><input name="S" value="F" type="radio" checked="checked"> Female</label>
            </li>
            <li><strong>Age:</strong>
                <input name="age" type="text" maxlength=2 size=6 >
            </li>
            <li><strong>Personality Type:</strong>
                <input name="personality" type="text" maxlength=4 size=6 >
                (<a href="http://www.humanmetrics.com/cgi-win/JTypes2.asp ">Don't know your type?</a>)
            </li>
            <li><strong>Favorite OS:</strong>
                <select name="OS">
                    <option value="Windows">Windows</option>
                    <option value="Mac">Mac OS X</option>
                    <option value="Linux" selected="selected">Linux</option>
                </select>
            </li>
            <li><strong>Seeking age:</strong>
                <input name="minAge" type="text" maxlength=2 size="6" placeholder="min"> to <input name="maxAge" type="text" maxlength=2 size="6" placeholder="max">
            </li>
        </ul>

        <input type="submit" value="Sign Up">
</fieldset>
</form>

<?php include "bottom.html"; ?>