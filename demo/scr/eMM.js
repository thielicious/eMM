window.jQuery ? 
	
	$.fn.eMM = function(get) {

		let getForm = $(this),
			input = getForm.serializeArray(),
			data = {},
			clear = [];

		getForm.submit(e => {
			e.preventDefault();
			
			let assign = (val) => {
				return $('form *[name="'+val+'"]');
			};
			
			$.each(input,(k, v) => {
				if (v.value != null) {
					data[v.name] = assign(v.name).val();
					clear.push(assign(v.name));
				}
			});
			
			$.post(
				get.php, 
				{ send: JSON.stringify(data) },
				result => {
					$(get.resp).html(result);
				}
			).always(
				clear.map(name => {
					$(name).val('')
				})
			);
		});	
	} 
: alert('eMM.js\n\n This PlugIn requires jQuery');