<template>
    <div class="p-4 sm:ml-64">
        <div class="mt-14">
            <qrcode-scanner
                :qrbox="250"
                :fps="10"
                style="width: 500px;"
                @result="onScan"
            />
        </div>
    </div>
</template>

<script>
export default {
    methods: {
        onScan(decodedText, decodedResult) {
            alert(decodedText)
        }
    }
}
</script>
