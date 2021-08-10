 <div class="col-sm-6 col-lg-4 px-2 mb-3">
                    <!-- Team -->
                    <div class="card h-100 transition-3d-hover">
                        <div class="card-body">
                            <div class="avatar avatar-lg avatar-circle mb-4">
                                <img class="avatar-img" src="{{ $item['photo'] }}"
                                    alt="Giedrius Balbierius">
                            </div>

                            <span
                                class="d-block small font-weight-bold text-cap mb-1">{{ $item['title'] }}</span>
                            <h4 class="text-lh-sm">{{ $item['name'] }}</h4>
                            <p class="font-size-1">
                                {{ $item['text'] }}
                            </p>
                        </div>

                        <div class="card-footer border-0 pt-0">
                            <!-- Social Networks -->
                            <ul class="list-inline mb-0 text-center">

                                <li class="list-inline-item">
                                    <a class="btn btn-xs btn-icon btn-soft-secondary rounded-lg" target="_blank"
                                        href="{{ $item['linked_in'] }}">
                                        <i class="lab la-linkedin-in"></i>
                                    </a>
                                </li>

                            </ul>
                            <!-- End Social Networks -->
                        </div>
                    </div>
                    <!-- End Team -->
                </div>