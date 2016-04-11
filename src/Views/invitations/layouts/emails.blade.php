
<table style="background-color: #f6f6f6; width: 100%; font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;">
    <tr>
        <td></td>
        <td width="600" style="display: block !important; max-width: 600px !important; margin: 0 auto !important; clear: both !important;" >

            <div style="max-width: 600px; margin: 0 auto; display: block; padding: 20px;" >

                <table width="100%" cellpadding="0" cellspacing="0" style="background: #fff; border: 1px solid #e9e9e9; border-radius: 3px;" >
                    <tr style=" background-color: #1AB394; font-size: 16px; color: #fff; font-weight: 500;" >
                        <td style="padding: 5px; border-top-left-radius: 3px;" width="80"><img src="{{ config('userinvitations.app.domain') }}img/logo.png" width="80" alt="logo"></td>
                        <td style="padding: 5px; border-top-right-radius: 3px; text-align: left;" >
                            <h2 style="color: #FFF">{{ trans('userinvitations.subject') }}</h2>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 10px !important;"  colspan="2">
                            {{ trans('userinvitations.hi', ['name' => $__user['name']]) }}&nbsp;{{ trans('userinvitations.greeting_message') }}
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 10px !important;"  colspan="2">
                            @section ('content') @show
                        </td>
                    </tr>
                </table>

                <div style=" width: 100%; clear: both; color: #999; padding: 20px;">
                    @section ('footer')

                        <table width="100%">
                            <tr>
                                <td style="text-align: center; padding: 0 0 20px;" >
                                    {{ trans('userinvitations.sent_to') }}&nbsp;<a href="mailto:{{ $guest_email }}" style="color: #999; font-size: 11px" >{{ $guest_email }}</a>
                                </td>
                            </tr>
                        </table>

                    @show
                </div>
            </div>

        </td>
        <td></td>
    </tr>
</table>


