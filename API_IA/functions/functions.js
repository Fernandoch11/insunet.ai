function makeajax(url, method){
    var xhr = new XMLHttpRequest();
    xhr.open(method, url, true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                var response = xhr.responseText;
                response = JSON.parse(response);
                if(response.status == "success"){
                    alert(response.message);
                    if(response.redirect){
                        window.location.href = "../vista/?strid="+response.redirect;
                    } else {
                        window.location.href = "../vista/?strid=TZLGtxBfvytd";
                    }
                } else if(response.status == "error"){
                    alert(response.message);
                    if(response.redirect){
                        window.location.href = "../vista/?strid="+response.redirect;
                    }
                }
            } else {
                alert("Error en la solicitud: " + xhr.statusText);
            }
        }
    };
    return xhr;
}


$(document).ready(function() {
    $('#newregister').on('click', function() {
        //window.location.href = "vista/?strid=TZLGtxBfvytd"
        window.location.href = "./register_user";
    });

    $('#login').on('click', function() {
        window.location.href = "./login";
    });

    $('#recovery').on('click', function() {
        window.location.href = "./recovery";
    });

    $('#returntologin').on('click', function() {
        window.location.href = "./login";
    });

    $('#backtorecovery').on('click', function() {
        window.location.href = "./recovery";
    });

    $('#search').on('click', function(){
        var search = $('#searchbox').val();
        var desde = $('#desde').val();
        var hasta = $('#hasta').val();
        var typesearch = $('#selectbox').val();

        $.ajax({
            url: "./controlador/controller.php",
            type: "POST",
            dataType: 'json',
            data: {
                "formid":"q0r1s2t3u4v5",
                "search":search,
                "desde":desde,
                "hasta":hasta,
                "tipo":typesearch
            },
            success: function(response){
                let html = "";
                console.log(response);
                var data = response;
                data.forEach(function(item){
                    html += "<tr>";

                    html += "<td class='newrow'>"+item[0]+"</td>";
                    html += "<td class='newrow'>"+item[1]+"</td>";
                    html += "<td class='newrow'>"+item[2]+"</td>";
                    html += "<td class='newrow'>"+item[3]+"%</td>";
                    html += "<td class='newrow'>"+item[4]+"</td>";

                    html += "</tr>";
                });

                if(document.getElementById('addrows')){
                    document.getElementById('addrows').innerHTML = html;
                }
            },
            error: function(xhr, estado, error){
                console.log("error", error);
            }
        });

    });

    $('#formdata').on('click', function(){ 
        $.ajax({
            url: "./controlador/controller.php",
            type: "POST",
            data: {
                "formid":"y2z3a4b5c6d7"
            },
            success: function(response){
                window.location.href = "./"+ response;
            },
            error: function(xhr, estado, error){
                console.log("redir error", error);
            }
        });
    });
});

$('#home').on('click', function() {
    $.ajax({
        url: "./controlador/controller.php",
        type: "POST",
        data: {
            "formid":"k4l5m6n7o8p9"
        },
        success: function(response){
            window.location.href = "./"+ response;
        },
        error: function(xhr, estado, error){
            console.log("redir error", error);
        }
    });
});

if(document.getElementById('myModal') && document.getElementById('closeModalBtn')){
    const modal = document.getElementById('myModal');
    const closeBtn = document.getElementById('closeModalBtn');
  
  closeBtn.addEventListener('click', () => {
    modal.style.display = 'none'; // ocultar
  });
  
  window.addEventListener('click', (e) => {
    if (e.target == modal) {
      modal.style.display = 'none'; // cerrar si se clickea fuera
    }
  });
}

$('#Sendapi').on('submit', function(e) {
    e.preventDefault();

    $.ajax({
        url: "./controlador/controller.php",
        type: "POST",
        data: $(this).serialize(),
        success: function(response){
            response = response.split("||");
            var probabilidad = response[1];
            var resultado = response[0];
            if(document.getElementById('myModal')){
                document.getElementById('diabetesProbability').textContent = (Number(probabilidad)*100).toFixed(2)+"%";
                document.getElementById('apiMessage').textContent = resultado;
                const modal = document.getElementById('myModal');
                modal.style.display = 'flex'; // mostrar
            }
        },
        erroor: function(xhr, estado, error){
            console.log("error", error);
        }
    });
});


function get_stimated_data(){
    $.ajax({
        url: "./controlador/controller.php",
        type: "POST",
        data: {
            formid:"i8j9k0l1m2n3"
        },
        success:function(response){
            console.log(response);
            response = response.split("||");

            const ctx = document.getElementById('miGrafico').getContext('2d');
            const miGrafico = new Chart(ctx, {
                type: 'bar', 
                data: {
                    labels: ['Datos diabtes'],
                    datasets: [
                        {
                            label: 'Probabilidad de Diabetes',
                            data: [parseInt(response[0])],
                            backgroundColor: 'red'
                        },
                        {
                            label: 'Probabilidad de no Diabetes',
                            data: [parseInt(response[1])],
                            backgroundColor: 'green'
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false
                }
            });

        },

        error: function(xhr, estado, error){
            console.error("error: ", error);
        }
    })
}

$('#tipoestimacion').on('change', function(){
    var option = document.getElementById('tipoestimacion').value;
    console.log(option);

    if(option == 'unico'){
        $('#form').show();
        $('#masive').css('display', 'none');
    }else{
        $('#form').css('display', 'none');
        $('#masive').show();

        //agrega un formulario que permita subir archivos de excel
        $('#masive').html(`
            <form id="uploadExcelForm" enctype="multipart/form-data">
            <label for="excelFile">Subir archivo Excel:</label>
            <input type="file" id="excelFile" name="excelFile" accept=".xlsx, .xls" />
            <input type="hidden" id="formid" name="formid" value="o4p5q6r7s8t9"/>
            <button type="submit">Subir</button>
            </form>
        `);
    }

})

$('#uploadExcelForm').on('submit', function(e) {
    e.preventDefault();
    var formData = new FormData(this);

    $.ajax({
    url: "./controlador/upload_excel.php",
    type: "POST",
    data: formData,
    processData: false,
    contentType: false,
    success: function(response) {
        alert("Archivo subido exitosamente");
        console.log(response);
    },
    error: function(xhr, estado, error) {
        console.error("Error al subir el archivo: ", error);
    }
    });
});