import { $, element } from "./tools.js";

export function startGame() {
  const $container = $("#game-container");

  const $form = element("form");
  const $p = element("p");
  const $input = element("input");
  const $button = element("button");
  const $indexContainer = element("div");
  const $indexs = [];
  for (let i = 1; i <= 10; i++) {
    const $index = element("div");
    $index.classList.add("index");
    $indexs.push($index);
  }

  $p.setAttribute("id", "word");
  $input.setAttribute("type", "text");
  $input.setAttribute("name", "translate");
  $button.setAttribute("type", "submit");
  $indexContainer.setAttribute("id", "index-container");

  $indexs.forEach((e) => {
    $indexContainer.appendChild(e);
  });

  $button.textContent = "Check";

  $form.append($p, $input, $button, $indexContainer);
  $container.innerHTML = "";
  $container.appendChild($form);

  return [$form, $p, $input, $indexContainer, $indexs];
}
