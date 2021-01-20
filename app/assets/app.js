import './styles/app.scss';
import 'materialize-css';
import 'materialize-css/dist/css/materialize.min.css';
import 'material-icons';

document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('select');
    var instances = M.FormSelect.init(elems);
});