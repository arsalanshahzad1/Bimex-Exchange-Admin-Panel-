<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Crypto Onramp</title>
    <meta name="description" content="A demo of Stripe onramp" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="onramp.css" />
    <script src="https://js.stripe.com/v3/"></script>
    <script src="https://crypto-js.stripe.com/crypto-onramp-outer.js"></script>
    <script src="onramp.js" defer></script>
    <script>
        // This is a public sample test API key.
        // Don’t submit any personally identifiable information in requests made with this key.
        // Sign in to see your own test API key embedded in code samples.
        const stripeOnramp = StripeOnramp("pk_test_TYooMQauvdEDq54NiTphI7jx");

        let session;

        initialize();

        async function initialize() {
            // Fetches an onramp session and captures the client secret
            const response = await fetch(
                "{{url('api/stripe-crypto')}}",
                {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: {
                        destination_currency: "usdc",
                        destination_exchange_amount: "13.37",
                        destination_network: "ethereum",
                    },
                });
            const { clientSecret } = await response.json();

            session = stripeOnramp
                .createSession({
                    clientSecret,
                    appearance: {
                        theme: "dark",
                    }
                })
                .addEventListener('onramp_session_updated', (e) => {
                    showMessage(`OnrampSession is now in ${e.payload.session.status} state.`)
                })
                .mount("#onramp-element");
        }

        // ------- UI helpers -------

        function showMessage(messageText) {
            const messageContainer = document.querySelector("#onramp-message");

            messageContainer.textContent = messageText;
        }
    </script>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, sans-serif;
            font-size: 16px;
            -webkit-font-smoothing: antialiased;
            display: flex;
            justify-content: center;
            align-content: center;
            height: 100vh;
            width: 100vw;
        }

        #root {
            display: flex;
            flex-direction: column;
        }

        #onramp-message {
            color: rgb(105, 115, 134);
            font-size: 16px;
            line-height: 20px;
            padding-top: 12px;
            text-align: center;
        }

        #onramp-element {
            min-width: min(450px, 60vw);
            margin-top: 24px;
        }
    </style>
</head>

<body>
    <div id="root">
        <div id="onramp-message"></div>
        <div id="onramp-element">
            <!--Stripe injects the Onramp widget-->
        </div>
    </div>
  
</body>

</html>