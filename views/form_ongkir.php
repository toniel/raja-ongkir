<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Cek Ongkir</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<link rel="manifest" href="<?= base_url() ?>manifest.json">
	<script
  src="https://code.jquery.com/jquery-3.3.1.js"
  integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
  crossorigin="anonymous"></script>
	<script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async=""></script>
	<script>
	    var OneSignal = window.OneSignal || [];
	    OneSignal.push(["init", {
	        appId: "fc465953-4c99-4249-a55d-3cf52305b051",
	        subdomainName: 'notifikasi-ci',
	        autoRegister: true,
	        promptOptions: {
	            /* These prompt options values configure both the HTTP prompt and the HTTP popup. */
	            /* actionMessage limited to 90 characters */
	            actionMessage: "We'd like to show you notifications for the latest news.",
	            /* acceptButtonText limited to 15 characters */
	            acceptButtonText: "ALLOW",
	            /* cancelButtonText limited to 15 characters */
	            cancelButtonText: "NO THANKS"
	        }
	    }]);
	</script>
	<script>
	    function subscribe() {
	        // OneSignal.push(["registerForPushNotifications"]);
	        OneSignal.push(["registerForPushNotifications"]);
	        event.preventDefault();
	    }
	    function unsubscribe(){
	        OneSignal.setSubscription(true);
	    }

	    var OneSignal = OneSignal || [];
	    OneSignal.push(function() {
	        /* These examples are all valid */
	        // Occurs when the user's subscription changes to a new value.
	        OneSignal.on('subscriptionChange', function (isSubscribed) {
	            console.log("The user's subscription state is now:", isSubscribed);
	            OneSignal.sendTag("user_id","4444", function(tagsSent)
	            {
	                // Callback called when tags have finished sending
	                console.log("Tags have finished sending!");
	            });
	        });

	        var isPushSupported = OneSignal.isPushNotificationsSupported();
	        if (isPushSupported)
	        {
	            // Push notifications are supported
	            OneSignal.isPushNotificationsEnabled().then(function(isEnabled)
	            {
	                if (isEnabled)
	                {
	                    console.log("Push notifications are enabled!");

	                } else {
	                    OneSignal.showHttpPrompt();
	                    console.log("Push notifications are not enabled yet.");
	                }
	            });

	        } else {
	            console.log("Push notifications are not supported.");
	        }
	    });


	</script>
</head>
<body>
	<div class="container py-5">
		<div class="row">
			<div class="col-md-12">
				<form>
				  <div class="form-group">
				    <label for="formGroupExampleInput">Provinsi Asal</label>
				    <select onChange="get_kota('asal')" id="provinsi_asal" class="form-control provinsi">
				    	
				    </select>
				  </div>
				  <div class="form-group">
				    <label for="formGroupExampleInput">Kota Asal</label>
				    <select id="kota_asal" class="form-control">
				    	
				    </select>
				  </div>

				  <div class="form-group">
				    <label for="formGroupExampleInput">Provinsi Tujuan</label>
				    <select id="provinsi_tujuan" onChange="get_kota('tujuan')" class="form-control provinsi">
				    	
				    </select>
				  </div>
				  <div class="form-group">
				    <label for="formGroupExampleInput">Kota Tujuan</label>
				    <select id="kota_tujuan" class="form-control">
				    	
				    </select>
				  </div>
				  
				  <div class="form-group">
				  	<label for="berat">Berat (bulatkan ke dalam kg)</label>
				  	<input type="number" name="berat" id="berat" class="form-control">
				  </div>

				  <div class="form-group">
				  	<label for="kurir">Kurir</label>
				  	<select onChange="get_ongkir()" name="kurir" id="kurir" class="form-control" >
				  		<option value="jne">JNE</option>
				  		<option value="pos">POS</option>
				  		<option value="tiki">TIKI</option>
				  	</select>
				  </div>

				  <div class="form-group">
				  	<label for="service">Service</label>
				  	<select name="service" id="service" class="form-control" >
				  		
				  	</select>
				  </div>
				</form>
			</div>
		</div>
	</div>


	<script type="text/javascript">
		$(function() {
			$.get("<?= site_url('ongkir/get_provinsi') ?>",{},(response)=>{
			let output = '';
			let provinsi = response.rajaongkir.results
			console.log(response)

			provinsi.map((val,i)=>{
				output+=`<option value="${val.province_id}" >${val.province}
		
				</option>`
			})
			$('.provinsi').html(output)

		})
		});

		function get_kota(type){
				let id_provinsi = $(`#provinsi_${type}`).val();
				$.get("<?= site_url('ongkir/get_kota/') ?>"+id_provinsi,{},(response)=>{
				let output = '';
				let kota = response.rajaongkir.results
				console.log(response)

				kota.map((val,i)=>{
					output+=`<option value="${val.city_id}" >${val.city_name}
				
					</option>`
				})
				$(`#kota_${type}`).html(output)

			})
		}

		function get_ongkir(){
			let berat = $('#berat').val();
			let asal = $('#kota_asal').val();
			let tujuan = $('#kota_tujuan').val();
			let kurir  = $('#kurir').val();
			let output = '';

				$.get("<?= site_url('ongkir/get_biaya/') ?>"+`${asal}/${tujuan}/${berat}/${kurir}`,{},(response)=>{
					console.log(response);
				let biaya = response.rajaongkir.results

				console.log(biaya)

				biaya.map((val,i)=>{
					for (var i = 0; i < val.costs.length; i++) {
						 let jenis_layanan= val.costs[i].service
						 val.costs[i].cost.map((val,i)=>{
						 	output +=`<option value="${val.value}" >${jenis_layanan} -Rp.${val.value} ${val.etd} Hari  </option>`
						 })
					}
				})
				$(`#service`).html(output)

			})
 		}

		
	</script>

</body>
</html>