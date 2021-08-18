<!-- This example requires Tailwind CSS v2.0+ -->
<div class="bg-white">
    <div class="max-w-2xl mx-auto py-16 px-4 sm:py-24 sm:px-6 lg:max-w-7xl lg:py-32 lg:px-8 lg:grid lg:grid-cols-12 lg:gap-x-8">
        <!-- Review Result Section  -->
        <x-tenant.product.reviews.result-reviews></x-tenant.product.reviews.result-reviews>
        <!-- End Review Result Section  -->

        <div class="mt-16 lg:mt-0 lg:col-start-6 lg:col-span-7">
            <h3 class="sr-only">Recent reviews</h3>
            <x-tenant.product.reviews.review-card></x-tenant.product.reviews.review-card>
        </div>
    </div>
    <x-tenant.product.reviews.add-review-modal></x-tenant.product.reviews.add-review-modal>
</div>

@section('script')
<script type="text/javascript">
    function openModal() {
        document.getElementById('interestModal').classList.remove("invisible");
    }

    function closeModal() {
        document.getElementById('interestModal').classList.add("invisible");
    }
</script>
@endsection