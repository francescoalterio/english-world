import { $, element } from "../tools.js";
import { Indexs } from "./Indexs.js";

export function QuestionComponent({ $container, wordsState }) {
  const $title = element("p");
  const $p = element("p");
  const $input = element("input");
  const $button = element("button");

  const $indexContainer = Indexs({ wordsState });

  $title.setAttribute("id", "title");
  $p.setAttribute("id", "word");
  $input.setAttribute("type", "text");
  $input.setAttribute("name", "translate");
  $input.setAttribute("placeholder", "correr...");
  $button.setAttribute("type", "submit");
  $button.classList.add("primary-button");

  $title.textContent = "The word to translate is...";
  $button.textContent = "Check";

  $container.append($title, $p, $input, $indexContainer, $button);

  return [$title, $p, $input, $indexContainer];
}
