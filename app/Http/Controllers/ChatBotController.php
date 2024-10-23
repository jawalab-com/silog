<?php

namespace App\Http\Controllers;

use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use OpenAI\Laravel\Facades\OpenAI;
use Twilio\Rest\Client;

class ChatBotController extends Controller
{
    public function listenToReplies(Request $request)
    {
        $from = $request->input('From');
        $body = $request->input('Body');
        Log::info("$from: $body");

        $client = new \GuzzleHttp\Client();
        try {
            // $response = $client->request('GET', "https://api.github.com/users/$body");
            // $githubResponse = json_decode($response->getBody());
            // if ($response->getStatusCode() == 200) {
            //     $message = "*Name:* $githubResponse->name\n";
            //     $message .= "*Bio:* $githubResponse->bio\n";
            //     $message .= "*Lives in:* $githubResponse->location\n";
            //     $message .= "*Number of Repos:* $githubResponse->public_repos\n";
            //     $message .= "*Followers:* $githubResponse->followers devs\n";
            //     $message .= "*Following:* $githubResponse->following devs\n";
            //     $message .= "*URL:* $githubResponse->html_url\n";
            //     $this->sendWhatsAppMessage($message, $from);
            // } else {
            //     $this->sendWhatsAppMessage($githubResponse->message, $from);
            // }
            $prompt = "Anda adalah asisten yang bernama Kyai Digital yang bertugas memberikan pencerahan tentang agama islam berdasarkan Al Quran dan Hadits. 
                Anda wajib memberikan salam islami.
                Tugas anda adalah menjawab pertanyaan terkait kitab suci alquran.
                Anda harus menjawab sumber berupa dalil dari surat alquran dan hadis, lengkap dengan tulisan arabnya.
                Jawablah dengan singkat, padat, dan jelas tanpa menjawab terlalu panjang.";
            $result = OpenAI::chat()->create([
                'model' => 'gpt-4o-mini',
                'messages' => [
                    ['role' => 'system', 'content' => $prompt],
                    ['role' => 'user', 'content' => $body],
                ],
            ]);
            
            $message = $result->choices[0]->message->content;
            Log::info('System: ' . $message);
            $this->sendWhatsAppMessage($message, $from);
        } catch (RequestException $th) {
            $response = json_decode($th->getResponse()->getBody());
            $this->sendWhatsAppMessage($response->message, $from);
        }
        return;
    }

    /**
     * Sends a WhatsApp message  to user using
     * @param string $message Body of sms
     * @param string $recipient Number of recipient
     */
    public function sendWhatsAppMessage(string $message, string $recipient)
    {
        $twilio_whatsapp_number = getenv('TWILIO_WHATSAPP_NUMBER');
        $account_sid = getenv("TWILIO_SID");
        $auth_token = getenv("TWILIO_AUTH_TOKEN");

        $client = new Client($account_sid, $auth_token);
        return $client->messages->create($recipient, array('from' => "whatsapp:$twilio_whatsapp_number", 'body' => $message));
    }
}