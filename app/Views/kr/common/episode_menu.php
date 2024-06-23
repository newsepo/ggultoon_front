<style>
  button {
    border-style: none;
    background-color: transparent;
    padding: 0px;
  }

  #episode_nav {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 0.5rem;
    width: 100%;
    max-width: 570px;
    position: fixed;
    bottom: 0px;
    box-sizing: border-box;
    padding: 0px 1rem;
    padding-bottom: 1rem;
    padding-top: 35px;
    background: linear-gradient(to bottom, rgba(255, 255, 255, 0) 0%, rgba(255, 255, 255, 1) 40%, rgba(255, 255, 255, 1) 96%);
    z-index: 1001;
  }

  #toonWrap.hide #episode_nav {
    max-width: 768px;
  }

  #episode_nav>button {
    width: 100%;
    height: 49px;
    border-radius: 0.5rem;
    box-sizing: border-box;
    padding: 14px 1rem;
    background-color: var(--primary);
    color: var(--text-able);
    border-style: none;
    font-weight: 500;
  }

  #episode_nav>button:first-of-type {
    background-color: var(--dark) !important;
    color: var(--text-white);
  }
</style>


<div id="episode_nav" style="display: none;">
  <button class="rent_all Text-lg">전체 대여</button>
  <button class="have_all Text-lg">전체 소장</button>
</div>