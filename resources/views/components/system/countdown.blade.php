<div class="text-center w-full p-6">
    <div class="timer inline text-4xl text-center font-bold" x-data="timer(new Date( {{ $date }}))" x-init="init();">
        <h1 class="relative we-days" x-text="time().days"></h1>
        <h1 class="we-hours" x-text="time().hours"></h1>
        <h1 class="we-minutes" x-text="time().minutes"></h1>
        <h1 class="we-seconds" x-text="time().seconds"></h1>
    </div>


    <style>
        .timer {
            display: flex;
            justify-content: center;
        }

        .timer h1 {
            position: relative;
        }



        .timer h1:after {
            position: absolute;
            top: 100%;
            left: 0;
            width: 100%;
            text-align: center;
            font-size: 14px;
            padding-left: 15px;
        }

        .timer .we-days:after {
            content: " {{ translate('days') }} ";
        }

        .timer .we-hours:after {
            content: " {{ translate('hours') }} ";
        }

        .timer .we-minutes:after {
            content: " {{ translate('minutes') }} ";
        }

        .timer .we-seconds:after {
            content: " {{ translate('sec') }} ";
        }



        .timer h1+h1:before {
            content: ":";
            padding: 0 10px;
        }
    </style>

    <script>
        function timer(expiry) {
    return {
        expiry: expiry,
        remaining:null,
        init() {
        this.setRemaining()
        setInterval(() => {
            this.setRemaining();
        }, 1000);
        },
        setRemaining() {
        const diff = this.expiry - new Date().getTime();
        this.remaining =  parseInt(diff / 1000);
        },
        days() {
        return {
            value:this.remaining / 86400,
            remaining:this.remaining % 86400
        };
        },
        hours() {
        return {
            value:this.days().remaining / 3600,
            remaining:this.days().remaining % 3600
        };
        },
        minutes() {
            return {
            value:this.hours().remaining / 60,
            remaining:this.hours().remaining % 60
        };
        },
        seconds() {
            return {
            value:this.minutes().remaining,
        };
        },
        format(value) {
        return ("0" + parseInt(value)).slice(-2)
        },
        time(){
            return {
            days:this.format(this.days().value),
            hours:this.format(this.hours().value),
            minutes:this.format(this.minutes().value),
            seconds:this.format(this.seconds().value),
        }
        },
    }
}

    </script>
</div>
