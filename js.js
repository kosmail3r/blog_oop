/**
 * Created by weagl on 23.11.2016.
 */
function validate_form ( )
{
    valid = true;

    if ( document.contact_form.name.value == "" )
    {
        alert ( "Please, input Your name." );
        valid = false;
    }
    if ( document.contact_form.email.value == "" )
    {
        alert ( "Please, input Your e-mail." );
        valid = false;
    }
    if ( document.contact_form.text.value == "" )
    {
        alert ( "Please, type anything in coment text." );
        valid = false;
    }


    return valid;
}