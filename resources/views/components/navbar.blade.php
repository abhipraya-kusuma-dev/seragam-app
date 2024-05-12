<header>
    <div class="base-container">
        <div class="navbar-container w-full h-[102px] border-b-[1px] border-black">
            <div class="content-container flex justify-center items-center h-full justify-between">
                <h1 class="font-semibold text-[40px] text-2xl ml-[46px]">Seragam <span class="bg-[#FF4343] text-white">Apps</span></h1>
                <form class="mr-[53px]" action="/logout" method="POST">
                    @csrf
                    <button class="bg-[#FF4343] w-[135px] h-[45px] rounded-lg font-semibold text-white text-[24px]" style="box-shadow: 2px 4px 6px gray">Logout</button>
                </form>
            </div>
            
        </div>
    </div>
</header>