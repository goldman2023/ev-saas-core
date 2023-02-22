@extends('central.layouts.central')

@section('main')
<div class="">

    <section class="bg-gray-500 bg-white">
        <div class="container px-4 mx-auto">
            <nav class="flex justify-between items-center py-8"><a class="text-gray-600 text-2xl leading-none" href="#">
                    <img class="h-8"
                        src="https://images.we-saas.com/insecure/fill/0/0/ce/0/plain/https://businesspress.fra1.digitaloceanspaces.com/uploads/33aa93f7-28b1-4c5f-b896-5a7153fbb7f3/1669384052_1661966732_businesspress.webp@webp"
                        alt="" width="auto"></a>



            </nav>
            <div class="relative pt-12 md:pt-16 pb-32 lg:pb-48 mb-48 lg:mb-64 bg-gray-500">
                <div class="max-w-2xl mb-16 mx-auto text-center">
                    <h2 class="mb-8 text-4xl lg:text-5xl text-white font-bold font-heading" contenteditable="false">
                        Welcome to BusinessPress</h2>
                    <p class="mb-8 text-lg text-gray-50" contenteditable="false">BusinessPress is running. Start by
                        creating a new site bellow</p>
                    <div>
                        <a class="inline-block w-full lg:w-auto py-3 px-6 mb-3 lg:mb-0 lg:mr-3 bg-white hover:bg-gray-50 text-gray-900 font-semibold border border-white rounded transition duration-200"
                            href="#">Create a site</a><a
                            class="inline-block w-full lg:w-auto py-3 px-6 text-gray-50 hover:text-gray-100 font-bold border rounded"
                            href="#">Get started guide</a>
                    </div>
                </div>
                <div class="relative max-w-3xl mx-auto">
                    <img class="absolute top-0 left-0 mx-auto w-full h-64 lg:h-96 rounded-xl object-cover"
                        src="central/screenshot.png" alt="" contenteditable="false">
                </div>
            </div>
        </div>
        <div class="hidden navbar-menu fixed top-0 left-0 bottom-0 w-5/6 max-w-sm z-50">
            <div class="navbar-backdrop fixed inset-0 bg-gray-800 opacity-25"></div>
            <nav class="relative flex flex-col py-6 px-6 w-full h-full bg-white border-r overflow-y-auto">
                <div class="flex items-center mb-8">
                    <a class="mr-auto text-2xl font-semibold leading-none" href="#">
                        <img class="h-8" src="mockup-assets/logos/shuffle-ux.svg" alt="" width="auto"></a>
                    <button class="navbar-close">
                        <svg class="h-6 w-6 text-gray-400 cursor-pointer hover:text-gray-500"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewbox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg></button>
                </div>
                <div>
                    <ul>
                        <li class="mb-1"><a
                                class="block p-4 text-sm font-semibold text-gray-900 hover:bg-gray-50 rounded"
                                href="#">About</a></li>
                        <li class="mb-1"><a
                                class="block p-4 text-sm font-semibold text-gray-900 hover:bg-gray-50 rounded"
                                href="#">Company</a></li>
                        <li class="mb-1"><a
                                class="block p-4 text-sm font-semibold text-gray-900 hover:bg-gray-50 rounded"
                                href="#">Services</a></li>
                        <li class="mb-1"><a
                                class="block p-4 text-sm font-semibold text-gray-900 hover:bg-gray-50 rounded"
                                href="#">Testimonials</a></li>
                    </ul>
                </div>
                <div class="mt-auto">
                    <p class="mt-6 mb-4 text-sm text-center text-gray-400">
                        <span>© 2021 All rights reserved.</span>
                    </p>
                </div>
            </nav>
        </div>
    </section>

    <section class="py-20">
        <div class="container px-4 mx-auto">
            <div class="mb-16 text-center">
                <span class="ext-sm text-gray-200 uppercase">NEED INSPIRATION?</span>
                <h2 class="mt-2 text-4xl lg:text-5xl font-bold font-heading">Get started with tutorials</h2>
            </div>
            <div class="flex flex-wrap -mx-4 -mb-8">
                <div class="w-full md:w-1/2 lg:w-1/3 mb-8 px-4">
                    <div>
                        <span class="mr-6 mb-6 flex items-center justify-center w-16 h-16 p-3 bg-gray-500 rounded-full">
                            <svg class="text-gray-50" width="32" height="32" viewbox="0 0 32 32" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M18.1332 14.5333C18.2665 14.6667 18.3998 14.6667 18.6665 14.6667H27.9998C28.7998 14.6667 29.3332 14.1333 29.3332 13.3333C29.3332 13.0667 29.3332 12.9333 29.1998 12.8L24.5332 3.46667C24.1332 2.8 23.3332 2.53334 22.6665 2.93334C22.5332 3.06667 22.2665 3.2 22.1332 3.46667L17.4665 12.8C17.1998 13.3333 17.4665 14.1333 18.1332 14.5333ZM23.3332 6.93334L25.8665 12H20.7998L23.3332 6.93334ZM8.6665 2.66667C5.33317 2.66667 2.6665 5.33334 2.6665 8.66667C2.6665 12 5.33317 14.6667 8.6665 14.6667C11.9998 14.6667 14.6665 12 14.6665 8.66667C14.6665 5.33334 11.9998 2.66667 8.6665 2.66667ZM8.6665 12C6.79984 12 5.33317 10.5333 5.33317 8.66667C5.33317 6.80001 6.79984 5.33334 8.6665 5.33334C10.5332 5.33334 11.9998 6.80001 11.9998 8.66667C11.9998 10.5333 10.5332 12 8.6665 12ZM14.2665 17.7333C13.7332 17.2 12.9332 17.2 12.3998 17.7333L8.6665 21.4667L4.93317 17.7333C4.39984 17.2 3.59984 17.2 3.0665 17.7333C2.53317 18.2667 2.53317 19.0667 3.0665 19.6L6.79984 23.3333L3.0665 27.0667C2.53317 27.6 2.53317 28.4 3.0665 28.9333C3.59984 29.4667 4.39984 29.4667 4.93317 28.9333L8.6665 25.2L12.3998 28.9333C12.9332 29.4667 13.7332 29.4667 14.2665 28.9333C14.7998 28.4 14.7998 27.6 14.2665 27.0667L10.5332 23.3333L14.2665 19.6C14.7998 19.0667 14.7998 18.2667 14.2665 17.7333ZM27.9998 17.3333H18.6665C17.8665 17.3333 17.3332 17.8667 17.3332 18.6667V28C17.3332 28.8 17.8665 29.3333 18.6665 29.3333H27.9998C28.7998 29.3333 29.3332 28.8 29.3332 28V18.6667C29.3332 17.8667 28.7998 17.3333 27.9998 17.3333ZM26.6665 26.6667H19.9998V20H26.6665V26.6667Z"
                                    fill="CurrentColor"></path>
                            </svg>
                        </span>
                        <h3 class="mb-2 text-2xl font-bold font-heading">Create a marketing website</h3>
                        <ul class="list-inside list-disc leading-loose text-gray-500">
                            <li><a class="hover:underline" href="">Etiam pellentesque non nibh</a></li>
                            <li><a class="hover:underline" href="">Mauris posuere</a></li>
                            <li><a class="hover:underline" href="">Tellus sit amet tempus vestibulum</a></li>
                            <li><a class="hover:underline" href="">Erat augue imperdiet neque</a></li>
                        </ul>
                    </div>
                </div>
                <div class="w-full md:w-1/2 lg:w-1/3 mb-8 px-4">
                    <div>
                        <span class="mr-6 mb-6 flex items-center justify-center w-16 h-16 p-3 bg-gray-500 rounded-full">
                            <svg class="text-gray-50" width="32" height="32" viewbox="0 0 32 32" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M18.1332 14.5333C18.2665 14.6667 18.3998 14.6667 18.6665 14.6667H27.9998C28.7998 14.6667 29.3332 14.1333 29.3332 13.3333C29.3332 13.0667 29.3332 12.9333 29.1998 12.8L24.5332 3.46667C24.1332 2.8 23.3332 2.53334 22.6665 2.93334C22.5332 3.06667 22.2665 3.2 22.1332 3.46667L17.4665 12.8C17.1998 13.3333 17.4665 14.1333 18.1332 14.5333ZM23.3332 6.93334L25.8665 12H20.7998L23.3332 6.93334ZM8.6665 2.66667C5.33317 2.66667 2.6665 5.33334 2.6665 8.66667C2.6665 12 5.33317 14.6667 8.6665 14.6667C11.9998 14.6667 14.6665 12 14.6665 8.66667C14.6665 5.33334 11.9998 2.66667 8.6665 2.66667ZM8.6665 12C6.79984 12 5.33317 10.5333 5.33317 8.66667C5.33317 6.80001 6.79984 5.33334 8.6665 5.33334C10.5332 5.33334 11.9998 6.80001 11.9998 8.66667C11.9998 10.5333 10.5332 12 8.6665 12ZM14.2665 17.7333C13.7332 17.2 12.9332 17.2 12.3998 17.7333L8.6665 21.4667L4.93317 17.7333C4.39984 17.2 3.59984 17.2 3.0665 17.7333C2.53317 18.2667 2.53317 19.0667 3.0665 19.6L6.79984 23.3333L3.0665 27.0667C2.53317 27.6 2.53317 28.4 3.0665 28.9333C3.59984 29.4667 4.39984 29.4667 4.93317 28.9333L8.6665 25.2L12.3998 28.9333C12.9332 29.4667 13.7332 29.4667 14.2665 28.9333C14.7998 28.4 14.7998 27.6 14.2665 27.0667L10.5332 23.3333L14.2665 19.6C14.7998 19.0667 14.7998 18.2667 14.2665 17.7333ZM27.9998 17.3333H18.6665C17.8665 17.3333 17.3332 17.8667 17.3332 18.6667V28C17.3332 28.8 17.8665 29.3333 18.6665 29.3333H27.9998C28.7998 29.3333 29.3332 28.8 29.3332 28V18.6667C29.3332 17.8667 28.7998 17.3333 27.9998 17.3333ZM26.6665 26.6667H19.9998V20H26.6665V26.6667Z"
                                    fill="CurrentColor"></path>
                            </svg>
                        </span>
                        <h3 class="mb-2 text-2xl font-bold font-heading">Create a custom theme</h3>
                        <ul class="list-inside list-disc leading-loose text-gray-500">
                            <li><a class="hover:underline" href="">Etiam pellentesque non nibh</a></li>
                            <li><a class="hover:underline" href="">Mauris posuere</a></li>
                            <li><a class="hover:underline" href="">Tellus sit amet tempus vestibulum</a></li>
                            <li><a class="hover:underline" href="">Erat augue imperdiet neque</a></li>
                        </ul>
                    </div>
                </div>
                <div class="w-full md:w-1/2 lg:w-1/3 mb-8 px-4">
                    <div>
                        <span class="mr-6 mb-6 flex items-center justify-center w-16 h-16 p-3 bg-gray-500 rounded-full">
                            <svg class="text-gray-50" width="32" height="32" viewbox="0 0 32 32" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M18.1332 14.5333C18.2665 14.6667 18.3998 14.6667 18.6665 14.6667H27.9998C28.7998 14.6667 29.3332 14.1333 29.3332 13.3333C29.3332 13.0667 29.3332 12.9333 29.1998 12.8L24.5332 3.46667C24.1332 2.8 23.3332 2.53334 22.6665 2.93334C22.5332 3.06667 22.2665 3.2 22.1332 3.46667L17.4665 12.8C17.1998 13.3333 17.4665 14.1333 18.1332 14.5333ZM23.3332 6.93334L25.8665 12H20.7998L23.3332 6.93334ZM8.6665 2.66667C5.33317 2.66667 2.6665 5.33334 2.6665 8.66667C2.6665 12 5.33317 14.6667 8.6665 14.6667C11.9998 14.6667 14.6665 12 14.6665 8.66667C14.6665 5.33334 11.9998 2.66667 8.6665 2.66667ZM8.6665 12C6.79984 12 5.33317 10.5333 5.33317 8.66667C5.33317 6.80001 6.79984 5.33334 8.6665 5.33334C10.5332 5.33334 11.9998 6.80001 11.9998 8.66667C11.9998 10.5333 10.5332 12 8.6665 12ZM14.2665 17.7333C13.7332 17.2 12.9332 17.2 12.3998 17.7333L8.6665 21.4667L4.93317 17.7333C4.39984 17.2 3.59984 17.2 3.0665 17.7333C2.53317 18.2667 2.53317 19.0667 3.0665 19.6L6.79984 23.3333L3.0665 27.0667C2.53317 27.6 2.53317 28.4 3.0665 28.9333C3.59984 29.4667 4.39984 29.4667 4.93317 28.9333L8.6665 25.2L12.3998 28.9333C12.9332 29.4667 13.7332 29.4667 14.2665 28.9333C14.7998 28.4 14.7998 27.6 14.2665 27.0667L10.5332 23.3333L14.2665 19.6C14.7998 19.0667 14.7998 18.2667 14.2665 17.7333ZM27.9998 17.3333H18.6665C17.8665 17.3333 17.3332 17.8667 17.3332 18.6667V28C17.3332 28.8 17.8665 29.3333 18.6665 29.3333H27.9998C28.7998 29.3333 29.3332 28.8 29.3332 28V18.6667C29.3332 17.8667 28.7998 17.3333 27.9998 17.3333ZM26.6665 26.6667H19.9998V20H26.6665V26.6667Z"
                                    fill="CurrentColor"></path>
                            </svg>
                        </span>
                        <h3 class="mb-2 text-2xl font-bold font-heading">Developer documentation</h3>
                        <ul class="list-inside list-disc leading-loose text-gray-500">
                            <li><a class="hover:underline" href="">Etiam pellentesque non nibh</a></li>
                            <li><a class="hover:underline" href="">Deployments and setup</a></li>
                            <li><a class="hover:underline" href="">Tellus sit amet tempus vestibulum</a></li>
                            <li><a class="hover:underline" href="">Erat augue imperdiet neque</a></li>
                        </ul>
                    </div>
                </div>
                <div class="w-full md:w-1/2 lg:w-1/3 mb-8 px-4">
                    <div>
                        <span class="mr-6 mb-6 flex items-center justify-center w-16 h-16 p-3 bg-gray-500 rounded-full">
                            <svg class="text-gray-50" width="32" height="32" viewbox="0 0 32 32" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M18.1332 14.5333C18.2665 14.6667 18.3998 14.6667 18.6665 14.6667H27.9998C28.7998 14.6667 29.3332 14.1333 29.3332 13.3333C29.3332 13.0667 29.3332 12.9333 29.1998 12.8L24.5332 3.46667C24.1332 2.8 23.3332 2.53334 22.6665 2.93334C22.5332 3.06667 22.2665 3.2 22.1332 3.46667L17.4665 12.8C17.1998 13.3333 17.4665 14.1333 18.1332 14.5333ZM23.3332 6.93334L25.8665 12H20.7998L23.3332 6.93334ZM8.6665 2.66667C5.33317 2.66667 2.6665 5.33334 2.6665 8.66667C2.6665 12 5.33317 14.6667 8.6665 14.6667C11.9998 14.6667 14.6665 12 14.6665 8.66667C14.6665 5.33334 11.9998 2.66667 8.6665 2.66667ZM8.6665 12C6.79984 12 5.33317 10.5333 5.33317 8.66667C5.33317 6.80001 6.79984 5.33334 8.6665 5.33334C10.5332 5.33334 11.9998 6.80001 11.9998 8.66667C11.9998 10.5333 10.5332 12 8.6665 12ZM14.2665 17.7333C13.7332 17.2 12.9332 17.2 12.3998 17.7333L8.6665 21.4667L4.93317 17.7333C4.39984 17.2 3.59984 17.2 3.0665 17.7333C2.53317 18.2667 2.53317 19.0667 3.0665 19.6L6.79984 23.3333L3.0665 27.0667C2.53317 27.6 2.53317 28.4 3.0665 28.9333C3.59984 29.4667 4.39984 29.4667 4.93317 28.9333L8.6665 25.2L12.3998 28.9333C12.9332 29.4667 13.7332 29.4667 14.2665 28.9333C14.7998 28.4 14.7998 27.6 14.2665 27.0667L10.5332 23.3333L14.2665 19.6C14.7998 19.0667 14.7998 18.2667 14.2665 17.7333ZM27.9998 17.3333H18.6665C17.8665 17.3333 17.3332 17.8667 17.3332 18.6667V28C17.3332 28.8 17.8665 29.3333 18.6665 29.3333H27.9998C28.7998 29.3333 29.3332 28.8 29.3332 28V18.6667C29.3332 17.8667 28.7998 17.3333 27.9998 17.3333ZM26.6665 26.6667H19.9998V20H26.6665V26.6667Z"
                                    fill="CurrentColor"></path>
                            </svg>
                        </span>
                        <h3 class="mb-2 text-2xl font-bold font-heading">Create new packages</h3>
                        <ul class="list-inside list-disc leading-loose text-gray-500">
                            <li><a class="hover:underline" href="">Create Laravel 9 Package </a></li>
                            <li><a class="hover:underline" href="">Mauris posuere</a></li>
                            <li><a class="hover:underline" href="">Tellus sit amet tempus vestibulum</a></li>
                            <li><a class="hover:underline" href="">Erat augue imperdiet neque</a></li>
                        </ul>
                    </div>
                </div>
                <div class="w-full md:w-1/2 lg:w-1/3 mb-8 px-4">
                    <div>
                        <span class="mr-6 mb-6 flex items-center justify-center w-16 h-16 p-3 bg-gray-500 rounded-full">
                            <svg class="text-gray-50" width="32" height="32" viewbox="0 0 32 32" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M18.1332 14.5333C18.2665 14.6667 18.3998 14.6667 18.6665 14.6667H27.9998C28.7998 14.6667 29.3332 14.1333 29.3332 13.3333C29.3332 13.0667 29.3332 12.9333 29.1998 12.8L24.5332 3.46667C24.1332 2.8 23.3332 2.53334 22.6665 2.93334C22.5332 3.06667 22.2665 3.2 22.1332 3.46667L17.4665 12.8C17.1998 13.3333 17.4665 14.1333 18.1332 14.5333ZM23.3332 6.93334L25.8665 12H20.7998L23.3332 6.93334ZM8.6665 2.66667C5.33317 2.66667 2.6665 5.33334 2.6665 8.66667C2.6665 12 5.33317 14.6667 8.6665 14.6667C11.9998 14.6667 14.6665 12 14.6665 8.66667C14.6665 5.33334 11.9998 2.66667 8.6665 2.66667ZM8.6665 12C6.79984 12 5.33317 10.5333 5.33317 8.66667C5.33317 6.80001 6.79984 5.33334 8.6665 5.33334C10.5332 5.33334 11.9998 6.80001 11.9998 8.66667C11.9998 10.5333 10.5332 12 8.6665 12ZM14.2665 17.7333C13.7332 17.2 12.9332 17.2 12.3998 17.7333L8.6665 21.4667L4.93317 17.7333C4.39984 17.2 3.59984 17.2 3.0665 17.7333C2.53317 18.2667 2.53317 19.0667 3.0665 19.6L6.79984 23.3333L3.0665 27.0667C2.53317 27.6 2.53317 28.4 3.0665 28.9333C3.59984 29.4667 4.39984 29.4667 4.93317 28.9333L8.6665 25.2L12.3998 28.9333C12.9332 29.4667 13.7332 29.4667 14.2665 28.9333C14.7998 28.4 14.7998 27.6 14.2665 27.0667L10.5332 23.3333L14.2665 19.6C14.7998 19.0667 14.7998 18.2667 14.2665 17.7333ZM27.9998 17.3333H18.6665C17.8665 17.3333 17.3332 17.8667 17.3332 18.6667V28C17.3332 28.8 17.8665 29.3333 18.6665 29.3333H27.9998C28.7998 29.3333 29.3332 28.8 29.3332 28V18.6667C29.3332 17.8667 28.7998 17.3333 27.9998 17.3333ZM26.6665 26.6667H19.9998V20H26.6665V26.6667Z"
                                    fill="CurrentColor"></path>
                            </svg>
                        </span>
                        <h3 class="mb-2 text-2xl font-bold font-heading">Neque porro quisquam est</h3>
                        <ul class="list-inside list-disc leading-loose text-gray-500">
                            <li><a class="hover:underline" href="">Etiam pellentesque non nibh</a></li>
                            <li><a class="hover:underline" href="">Mauris posuere</a></li>
                            <li><a class="hover:underline" href="">Tellus sit amet tempus vestibulum</a></li>
                            <li><a class="hover:underline" href="">Erat augue imperdiet neque</a></li>
                        </ul>
                    </div>
                </div>
                <div class="w-full md:w-1/2 lg:w-1/3 mb-8 px-4">
                    <div>
                        <span class="mr-6 mb-6 flex items-center justify-center w-16 h-16 p-3 bg-gray-500 rounded-full">
                            <svg class="text-gray-50" width="32" height="32" viewbox="0 0 32 32" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M18.1332 14.5333C18.2665 14.6667 18.3998 14.6667 18.6665 14.6667H27.9998C28.7998 14.6667 29.3332 14.1333 29.3332 13.3333C29.3332 13.0667 29.3332 12.9333 29.1998 12.8L24.5332 3.46667C24.1332 2.8 23.3332 2.53334 22.6665 2.93334C22.5332 3.06667 22.2665 3.2 22.1332 3.46667L17.4665 12.8C17.1998 13.3333 17.4665 14.1333 18.1332 14.5333ZM23.3332 6.93334L25.8665 12H20.7998L23.3332 6.93334ZM8.6665 2.66667C5.33317 2.66667 2.6665 5.33334 2.6665 8.66667C2.6665 12 5.33317 14.6667 8.6665 14.6667C11.9998 14.6667 14.6665 12 14.6665 8.66667C14.6665 5.33334 11.9998 2.66667 8.6665 2.66667ZM8.6665 12C6.79984 12 5.33317 10.5333 5.33317 8.66667C5.33317 6.80001 6.79984 5.33334 8.6665 5.33334C10.5332 5.33334 11.9998 6.80001 11.9998 8.66667C11.9998 10.5333 10.5332 12 8.6665 12ZM14.2665 17.7333C13.7332 17.2 12.9332 17.2 12.3998 17.7333L8.6665 21.4667L4.93317 17.7333C4.39984 17.2 3.59984 17.2 3.0665 17.7333C2.53317 18.2667 2.53317 19.0667 3.0665 19.6L6.79984 23.3333L3.0665 27.0667C2.53317 27.6 2.53317 28.4 3.0665 28.9333C3.59984 29.4667 4.39984 29.4667 4.93317 28.9333L8.6665 25.2L12.3998 28.9333C12.9332 29.4667 13.7332 29.4667 14.2665 28.9333C14.7998 28.4 14.7998 27.6 14.2665 27.0667L10.5332 23.3333L14.2665 19.6C14.7998 19.0667 14.7998 18.2667 14.2665 17.7333ZM27.9998 17.3333H18.6665C17.8665 17.3333 17.3332 17.8667 17.3332 18.6667V28C17.3332 28.8 17.8665 29.3333 18.6665 29.3333H27.9998C28.7998 29.3333 29.3332 28.8 29.3332 28V18.6667C29.3332 17.8667 28.7998 17.3333 27.9998 17.3333ZM26.6665 26.6667H19.9998V20H26.6665V26.6667Z"
                                    fill="CurrentColor"></path>
                            </svg>
                        </span>
                        <h3 class="mb-2 text-2xl font-bold font-heading">Neque porro quisquam est</h3>
                        <ul class="list-inside list-disc leading-loose text-gray-500">
                            <li><a class="hover:underline" href="">Etiam pellentesque non nibh</a></li>
                            <li><a class="hover:underline" href="">Mauris posuere</a></li>
                            <li><a class="hover:underline" href="">Tellus sit amet tempus vestibulum</a></li>
                            <li><a class="hover:underline" href="">Erat augue imperdiet neque</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>


</div>
@endsection
