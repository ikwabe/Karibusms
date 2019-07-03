<?php

class Gcm {

    private static $HEADER = array(//This works, for GCM not FCM
        'Authorization: key=AIzaSyCEmicefa98_ECH5kFDfqADl_Sl5cQusuA',
        'Content-Type: application/json'
    );
//    private static $HEADER = array(
//        'Authorization: key=AAAAq5tzDr4:APA91bEj4PuLTBSFN8oyMq3mNaxbMc7jqvh361e20Ki9ZKfe8VJPC-24fZP13Utp7-TMP_U3v-6jNGvc3TDDrPZVt7y7VX7ock_Dt5gZnLhTB-lPZaE8oKTj6wzhi79C0tjwr8lY_5CtZ3AtUieL3qCB-l5OsMcWIA',
//        'Content-Type: application/json'
//    );

    //  const OLD_GCM_URL = 'https://android.googleapis.com/gcm/send';
    const URL = 'https://fcm.googleapis.com/fcm/send';
    //const BROADCAST_ID = 'APA91bGawSnXF9n00n00gZpkkCfNRIaOJvzjFeC7X6RgcW7wNoc83snrcigx_MpzW6SPtt6LShKu-gNnG6UwQ490z8K8ZQ35esAN_dSxSOY9hqkq3Z_CywGVdoHEQniXEY7DpjnWxlq_QIs9aNOeRKi25YygT8fd_g';
   // const INETS_ID = 'APA91bGaJRoN0ZsQCPRurDGfd5aTHj0k2j4FbQdw_w0DwfoeSnMM8OF0tjbYm53dgWHX91JF9uTG05jJ9RRPRK6qdoYjj9jhIpyihwmwTAA33wiVLs6yNxVQfCXcDL7fl2p7aeE0UN1ntaAp0QP9KMWjhi50nc4vbg';

    /**
     * 
     * @param mixed $message
     * @param string $gcm_id
     * @return stdClass
     */
    private static function push_to_id($message, $gcm_id) {
        $fields = array(
            'registration_ids' => array($gcm_id),
            'data' => array("Notice" => $message),
        );
        //die(json_encode($fields,JSON_PRETTY_PRINT));
        return (object) json_decode(self::curl($fields), TRUE);
    }

    public static function send($sms_content, $phone_number, $username, $gcm_id) {
        $return = array(
            'message' => $sms_content,
            'link' => 'www.karibusms.com/' . $username,
            'status' => 'success',
            'phone_number' => $phone_number
        );
        $push = self::push_to_id($return, $gcm_id);
        //$fcm_response = self::firebase($return, $gcm_id);
        return $push;
    }

    /**
     * @param string $action action to be done on the mobile
     * @param string $extra any extra data depending on the action
     * @param string $gcm_id
     * @return stdClass
     */
    public static function sendAction($action, $extra,$gcm_id) {
        $return = array(
            'action' => $action,
            'extra' => $extra
        );
        $push = self::push_to_id($return, $gcm_id);
        return $push;
    }

    public static function format_smart_sms($username, $message_content) {
        $short_url = 'www.karibusms.com/' . $username;
        $message = $username . ': 
' . $message_content . '
' . $short_url;
        return $message;
    }

    public static function push_from_platform($message) {
//        $fields = array(
//            'registration_ids' => array(self::INETS_ID),
//            'data' => array("Notice" => $message),
//        );
        //return self::curl($fields);
    }

    /**
     * 
     * @param string $message
     * @return Object
     */
    public static function push_to_all($message) {
        $fields = array(
//	   / 'registration_ids' => array('NULL'),
            "to" => "/topics/global",
            'data' => array("Notice" => 1,
                "title" => 'karibuSMS',
                'message' => $message
            )
        );
        return (object) json_decode(self::curl($fields), TRUE);
    }

    /**
     * @uses gcm send push notification and not sms as push_to_id did
     * @param type $message
     * @param type $gcm_id
     * @return type
     */
    public static function push_to_phoneid($message, $gcm_id) {
        $fields = array(
            'registration_ids' => array($gcm_id),
            'data' => array("Notice" => 1,
                "title" => 'karibuSMS',
                'message' => $message
            )
        );
        return (object) json_decode(self::curl($fields), TRUE);
    }

    private static function curl($fields) {
        // Open connection
        $ch = curl_init();
        // Set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, self::URL);

        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, self::$HEADER);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

        // Execute post
        $result = curl_exec($ch);

        curl_close($ch);

        return $result;
    }


    public static function firebase($to_send, $gcm_id){

        $new_fields = array(
            'to' =>$gcm_id,
            'collapse_key' => 'type_a',
            'data' => array("Notice" => $to_send)
        );
        // dd($new_fields);

        $ch = curl_init();
        // Set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization: key=AAAAq5tzDr4:APA91bEj4PuLTBSFN8oyMq3mNaxbMc7jqvh361e20Ki9ZKfe8VJPC-24fZP13Utp7-TMP_U3v-6jNGvc3TDDrPZVt7y7VX7ock_Dt5gZnLhTB-lPZaE8oKTj6wzhi79C0tjwr8lY_5CtZ3AtUieL3qCB-l5OsMcWIA',
            'Content-Type: application/json'
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($new_fields));

        // Execute post
        $result = curl_exec($ch);

        curl_close($ch);
        return $result;
    }

}