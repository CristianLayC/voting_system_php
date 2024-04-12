<!DOCTYPE html>
<?php include 'layouts/header.php'; ?>
<body>
<div class="container">
    <h2 class="title text-center">Formulario de votación</h2>
    
    <div class="card">
        <form id="voting-form" method="POST">
            <div class="form-group">
                <label class="fw-bold" for="name">Nombre & Apellido<span>*</span></label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Ingrese su nombre y apellido" required>
                <div id="name-feedback" class="invalid-feedback">Campo vacío</div>
            </div>

            <div class="form-group">
                <label class="fw-bold" for="alias">Alias</label>
                <input type="text" class="form-control" id="alias" name="alias" placeholder="Ingrese su alias">
            </div>
            
            <div class="form-group">
                <label class="fw-bold" for="rut">R.U.T.<span>*</span></label>
                <input type="text" class="form-control" id="rut" name="rut" placeholder="Ingrese su RUT" required>
                <div id="rut-feedback" class="invalid-feedback">Rut invalido</div>
            </div>

            <div class="form-group">
                <label class="fw-bold" for="email">Correo electrónico<span>*</span></label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Ingrese su correo electrónico" required>
                <div id="email-feedback" class="invalid-feedback">Correo invalido</div>
            </div>

            <div class="form-group">
                <label class="fw-bold" for="region">Región<span>*</span></label>
                <select class="form-control" id="region" name="region" required>
                    <option value="">Seleccione una región</option>
                </select>
            </div>

            <div class="form-group">
                <label class="fw-bold" for="commune">Comuna<span>*</span></label>
                <select class="form-control" id="commune" name="commune" required disabled>
                    <option value="1">Comuna 1</option>
                    <option value="2">Comuna 2</option>
                    <option value="3">Comuna 3</option>
                </select>
            </div>

            <div class="form-group">
                <label class="fw-bold" for="candidate">Candidato<span>*</span></label>
                <select class="form-control" id="candidate" name="candidate" required>
                    <option value="">Seleccione un candidato</option>
                </select>
            </div>

            <div class="form-group">
                <label class="fw-bold col-xs-12">¿Cómo se enteró de nosotros?</label>
                
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="whoRRSS" name="whoRRSS" value="Redes sociales">
                    <label class="form-check-label" for="whoRRSS"><i class="fa-solid fa-square-rss"></i>Redes sociales</label>
                </div>
                
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="whoIE" name="whoIE" value="Búsqueda en Internet">
                    <label class="form-check-label" for="whoIE"><i class="fa-solid fa-globe"></i>Búsqueda en Internet</label>
                </div>
                
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="whoFriend" name="whoFriend" value="Recomendación de un amigo">
                    <label class="form-check-label" for="whoFriend"><i class="fa-solid fa-user-group"></i>Recomendación de un amigo</label>
                </div>
                
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="whoTV" name="whoTV" value="Anuncio de Televisión">
                    <label class="form-check-label" for="whoTV"><i class="fa-solid fa-tv"></i>Anuncio de Televisión</label>
                </div>
            </div>

            <div class="text-center">
                <button id="send" type="button" class="btn btn-primary">Votar</button>
            </div>
        </form>
    </div>
</div>

<div id="toastSuccess" class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
  <div class="d-flex">
    <div class="toast-body">
      Votación registrada
    </div>
    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
  </div>
</div>

<div id="toastForm" class="toast align-items-center text-bg-warning border-0" role="alert" aria-live="assertive" aria-atomic="true">
  <div class="d-flex">
    <div class="toast-body">
      Formulario incompleto
    </div>
    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
  </div>
</div>

<script type="text/javascript">
    function nameValidate(){
        var response = false;
        var name = $('#name').val(); 
        var obj = $('#name');

        if( name === ''){
            $(obj).removeClass('is-valid');
            $(obj).addClass('is-invalid');
            $('#name-feedback').show();
        }else{
            $(obj).removeClass('is-invalid');
            $(obj).addClass('is-valid');
            $('#name-feedback').hide();
            response = true;
        }

        return response;
    }
    function emailValidate(){
        const email = $('#email').val();
        var obj = $('#email');
        const validate = new RegExp(/^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/);
        var response = false;

        if (validate.test(email) == false){
            $(obj).removeClass('is-valid');
            $(obj).addClass('is-invalid');
            $('#email-feedback').show();
        }else{
            $(obj).removeClass('is-invalid');
            $(obj).addClass('is-valid');
            $('#email-feedback').hide();
            response = true;
        }

        return response;
    }

    function rutReview(rut) {
        rut = rut.replace(/[^\dkK]/g, ''); // Eliminar guiones y puntos
        const dv = rut.slice(-1).toUpperCase();
        let rutNum = parseInt(rut.slice(0, -1), 10);

        let num = 0; 
        let multi = 1;

        if (rut.length < 2)
            return false;
        
        while (rutNum > 0) {
            multi++;
            if (multi === 8) 
                multi = 2;
            num += (rutNum % 10) * multi;
            rutNum = Math.floor(rutNum / 10);
        }

        const res = num % 11;
        const digit = (11 - res).toString();
        
        if (digit === '10') 
            return dv === 'K';
        if (digit === '11') 
            return dv === '0';

        return dv === digit;
    }


    function rutValidate(){
        var response = false;
        const rut = $('#rut').val();
        var obj = $('#rut');
        const validate = new RegExp(/^0*(\d{1,3}(\.?\d{3})*)\-?([\dkK])$/);
        var allow = validate.test(rut);

        if ( allow != false){
            allow = rutReview( rut );

            if ( allow != false){
                $(obj).removeClass('is-invalid');
                $(obj).addClass('is-valid');
                $('#rut-feedback').hide();
                response = true;
            }
        }

        if ( allow == false){
            $(obj).removeClass('is-valid');
            $(obj).addClass('is-invalid');
            $('#rut-feedback').show();            
        }

        return response;
    }

    function searchRegions(){
        $.ajax({
            type: "POST",                 
            url: "controllers/voteController.php",
            data: { method: 'searchRegions' },
            success: function(data){
                $('#region').html(data);
            }
        });
    }

    function searchCommunes(){
        const region = $('#region').val()
        $.ajax({
            type: "POST",                 
            url: "controllers/voteController.php",
            data: { method: 'searchCommunes', region: region },
            success: function(data){
                $('#commune').html(data);
                $('#commune').removeAttr('disabled');
            }
        });
    }

    function searchCandidates(){
        $.ajax({
            type: "POST",                 
            url: "controllers/voteController.php",
            data: { method: 'searchCandidates' },
            success: function(data){
                $('#candidate').html(data);
            }
        });
    }

    function validateForm(){
        var response = false;

        if(nameValidate())
            if(rutValidate())
                if(emailValidate())
                    response = true;

        return response;
    }
</script>

<script type="text/javascript">
    searchRegions();
    searchCandidates();
    
	$(document).ready(function(){
        searchCommunes();

        $('#send').click(function(e){
		    e.preventDefault();

            let allow = false;
            //Valición de formualrio
            allow = validateForm();

            if( allow ){
                var formData = $('form').serialize();

                $.ajax({
                    type: "POST",                 
                    url: "controllers/voteController.php",
                    data: { method: 'addVote', vote: formData },
                    dataType: 'json',
                    success: function(data){
                        if(data.status == 'success'){
                            $('#toastSuccess').show();
                        }
                    }
                });
            }else{
                $('#toastForm').show();
            }
	    });

        $('#email').blur( function(){
            emailValidate();
        });

        $('#rut').keyup( function(){
            rutValidate();
        });

        $('#region').change( function(){
            searchCommunes();
        });
	});
</script>

<?php include 'layouts/footer.php'; ?>
