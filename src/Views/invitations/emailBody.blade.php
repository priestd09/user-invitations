@extends('vendor.gocanto.invitations.layouts.emails')

@section ('content')

	<table width="100%" cellpadding="0" cellspacing="0">

		<tr>
			<td style="padding: 0 0 20px;" >
				{{ trans('userinvitations.body') }}
			</td>
		</tr>
		<tr>
			<td style="padding: 0 0 20px;" >&nbsp;</td>
		</tr>
		<tr>
			<td style="padding: 0 0 20px;" >
				<a href="{{ config('userinvitations.app.sign_up_url') . '?token='.urlencode($confirmation_token) }}"
					style="
						text-decoration: none;
						color: #FFF;
						background-color: #1ab394;
					    border: solid #1ab394;
					    border-width: 5px 10px;
					    line-height: 2;
					    font-weight: bold;
					    text-align: center;
					    cursor: pointer;
					    display: inline-block;
					    border-radius: 5px;
					    text-transform: capitalize;"
				>
					{{ trans('userinvitations.button_label') }}
				</a>
			</td>
		</tr>

	</table>

@endsection