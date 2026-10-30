/*
 * お問い合わせフォームの入力内容を、送信に失敗しても残す。
 * ブラウザのセッション内（sessionStorage）だけに保存し、サーバーには保存しない。
 */
( function () {
	var form = document.getElementById( 'nc-contact-form' );

	if ( ! form || ! window.sessionStorage ) {
		return;
	}

	var KEY = 'nc-contact-draft';
	var FIELDS = [ 'name', 'church', 'email', 'message' ];
	var status = new URLSearchParams( window.location.search ).get( 'contact' );

	if ( 'sent' === status ) {
		sessionStorage.removeItem( KEY );
	} else if ( 'invalid' === status || 'error' === status || 'limit' === status ) {
		try {
			var saved = JSON.parse( sessionStorage.getItem( KEY ) || '{}' );

			FIELDS.forEach( function ( name ) {
				var field = form.elements[ name ];

				if ( field && typeof saved[ name ] === 'string' ) {
					field.value = saved[ name ];
				}
			} );
		} catch ( error ) {
			sessionStorage.removeItem( KEY );
		}
	}

	form.addEventListener( 'submit', function () {
		var draft = {};

		FIELDS.forEach( function ( name ) {
			var field = form.elements[ name ];

			if ( field ) {
				draft[ name ] = field.value;
			}
		} );

		sessionStorage.setItem( KEY, JSON.stringify( draft ) );
	} );
} )();
