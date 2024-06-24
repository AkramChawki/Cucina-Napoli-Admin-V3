<script src="https://cdn.tailwindcss.com"></script>
<x-filament::page>
    <!-- This example requires Tailwind CSS v2.0+ -->
    <main class="bg-white px-4 pt-16 pb-24 sm:px-6 sm:pt-24 lg:px-8 lg:py-32">
        <div class="max-w-3xl mx-auto">
            <div class="max-w-xl">
                <h1 class="text-sm font-semibold uppercase tracking-wide text-green-600">Merci!</h1>
                @if ($record->status == 'waiting')
                    <p class="mt-2 text-4xl font-extrabold tracking-tight sm:text-5xl">C'est en route !</p>
                    <p class="mt-2 text-base text-gray-500">Votre commande a été livrée et sera bientôt chez vous.</p>
                @else
                    <p class="mt-2 text-4xl font-extrabold tracking-tight sm:text-5xl">Commande Livrée !</p>
                @endif

                <dl class="mt-12 text-sm font-medium">
                    <dt class="text-gray-900">Code de commande :</dt>
                    <dd class="text-green-600 mt-2">{{ $record->num }}</dd>
                </dl>
            </div>

            <section aria-labelledby="order-heading" class="mt-10 border-t border-gray-200">

                @foreach ($record->items as $item)
                    <div class="py-10 border-b border-gray-200 flex space-x-6">
                        <img src="{{ asset('storage/' . $item->product->image) }}"
                            alt="Glass bottle with black plastic pour top and mesh insert."
                            class="flex-none w-20 h-20 object-center object-cover bg-gray-100 rounded-lg sm:w-40 sm:h-40">
                        <div class="flex-auto flex flex-col">
                            <div>
                                <h4 class="font-medium text-gray-900">
                                    <a href="#">{{ $item->product->name }} </a>
                                </h4>
                                <p class="mt-2 text-sm text-gray-600">{{ $item->product->text }}</p>
                            </div>
                            <div class="mt-6 flex-1 flex items-end">
                                <dl class="flex text-sm divide-x divide-gray-200 space-x-4 sm:space-x-6">
                                    <div class="flex">
                                        <dt class="font-medium text-gray-900">Quantité</dt>
                                        <dd class="ml-2 text-gray-700">{{ $item->qty }}</dd>
                                    </div>
                                    <div class="pl-4 flex sm:pl-6">
                                        <dt class="font-medium text-gray-900">Prix</dt>
                                        <dd class="ml-2 text-gray-700">
                                            {{ number_format($item->product->price, 2, '.') }}DH
                                        </dd>
                                    </div>
                                </dl>
                            </div>
                        </div>
                    </div>
                @endforeach

                <div class="sm:ml-40 sm:pl-6">
                    <h3 class="sr-only">Information de commande</h3>

                    <h4 class="sr-only">Adresse</h4>
                    <dl class="grid grid-cols-2 gap-x-6 text-sm py-10">
                        <div>
                            <dt class="font-medium text-gray-900">Adresse de livraison</dt>
                            <dd class="mt-2 text-gray-700">
                                <address class="not-italic">
                                    <span class="block">{{ $record->adress }}</span>
                                </address>
                            </dd>
                        </div>
                        <div>
                            <dt class="font-medium text-gray-900">Telephone</dt>
                            <dd class="mt-2 text-gray-700">
                                <address class="not-italic">
                                    <span class="block">{{ $record->telephone }}</span>
                                </address>
                            </dd>
                        </div>
                        <div>
                            <dt class="font-medium text-gray-900">Email</dt>
                            <dd class="mt-2 text-gray-700">
                                <address class="not-italic">
                                    <span class="block">{{ $record->email }}</span>
                                </address>
                            </dd>
                        </div>
                    </dl>



                    <dl class="space-y-6 border-t border-gray-200 text-sm pt-10">
                        <div class="flex justify-between">
                            <dt class="font-medium text-gray-900">Total</dt>
                            <dd class="text-gray-700">{{ number_format($record->total, 2, '.') }}DH</dd>
                        </div>
                    </dl>
                    <h3 class="text-lg my-4 font-semibold">Notes Sur la Commande</h3>
                    <p class="mt-2 text-sm text-gray-600">{{ $record->notes }}</p>
                </div>
            </section>
        </div>
    </main>


</x-filament::page>
